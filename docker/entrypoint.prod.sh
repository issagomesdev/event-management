#!/usr/bin/env bash
set -e

wait_for_mysql() {
    echo "Aguardando o MySQL em ${DB_HOST}:${DB_PORT}..."
    until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
        sleep 2
    done
    echo "MySQL disponível."
}

wait_for_mysql

php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Mídia enviada em runtime é servida pelo nginx direto do volume
# compartilhado (ver docker/nginx/default.prod.conf) — não depende do
# symlink public/storage, que exigiria escrita em public/ (somente leitura
# na imagem de produção).

exec "$@"
