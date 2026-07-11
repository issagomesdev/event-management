#!/usr/bin/env bash
set -e

# storage/ e bootstrap/cache ficam em volumes nomeados (não no bind mount
# do código-fonte) — bind mounts do Windows/WSL2 são muito mais lentos
# para I/O de arquivos, e é exatamente isso que o Laravel bate toda
# requisição (compilação de views, cache, sessão). Como volume nomeado
# começa vazio, recria a árvore de diretórios que o Laravel espera.
mkdir -p \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chmod -R ugo+rwX storage bootstrap/cache 2>/dev/null || true

if [ ! -L public/storage ]; then
    php artisan storage:link >/dev/null 2>&1 || true
fi

exec "$@"
