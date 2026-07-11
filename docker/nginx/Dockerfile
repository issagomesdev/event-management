# syntax=docker/dockerfile:1

########################################
# assets: build dos assets front-end (Vite), só para gerar public/build
########################################
FROM node:20-alpine AS assets

WORKDIR /app
COPY package.json ./
RUN npm install
COPY resources/ resources/
COPY vite.config.js ./
RUN npm run build

########################################
# nginx: imagem enxuta, serve estáticos e repassa PHP ao php-fpm
########################################
FROM nginx:1.27-alpine

COPY docker/nginx/default.prod.conf /etc/nginx/conf.d/default.conf
COPY public/ /var/www/public/
COPY --from=assets /app/public/build /var/www/public/build
