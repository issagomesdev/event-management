# syntax=docker/dockerfile:1

########################################
# base: PHP-FPM + extensões comuns a dev e produção
########################################
FROM php:8.2-fpm-alpine AS base

RUN apk add --no-cache \
        bash \
        curl \
        freetype-dev \
        icu-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
        oniguruma-dev \
        zip \
        unzip \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        pcntl \
        pdo_mysql \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && rm -rf /var/cache/apk/*

WORKDIR /var/www

########################################
# dev: composer + xdebug opcional, código montado via volume
########################################
FROM base AS dev

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ARG WITH_XDEBUG=false
RUN if [ "$WITH_XDEBUG" = "true" ]; then \
        pecl install xdebug && docker-php-ext-enable xdebug; \
    fi

COPY docker/php/dev.ini /usr/local/etc/php/conf.d/99-dev.ini
COPY docker/entrypoint.dev.sh /usr/local/bin/entrypoint.dev.sh
RUN chmod +x /usr/local/bin/entrypoint.dev.sh

ENTRYPOINT ["entrypoint.dev.sh"]
CMD ["php-fpm"]

########################################
# vendor: dependências PHP de produção (sem dev, autoload otimizado)
########################################
FROM base AS vendor

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-scripts \
        --no-autoloader \
        --no-interaction \
        --prefer-dist

COPY . .
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

########################################
# assets: build dos assets front-end (Vite)
########################################
FROM node:20-alpine AS assets

WORKDIR /app
COPY package.json ./
RUN npm install
COPY resources/ resources/
COPY vite.config.js ./
RUN npm run build

########################################
# prod: imagem enxuta, sem composer/node, opcache agressivo
########################################
FROM base AS prod

RUN docker-php-ext-enable opcache
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/99-opcache.ini

COPY --from=vendor /var/www /var/www
COPY --from=assets /app/public/build /var/www/public/build

COPY docker/entrypoint.prod.sh /usr/local/bin/entrypoint.prod.sh
RUN chmod +x /usr/local/bin/entrypoint.prod.sh \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

USER www-data

ENTRYPOINT ["entrypoint.prod.sh"]
CMD ["php-fpm"]
