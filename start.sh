#!/usr/bin/env bash
set -e

echo "[start] Waiting for MySQL to be ready..."

# Wait up to 60 seconds for the database to accept connections
MAX_TRIES=30
TRIES=0
until php artisan db:show --json > /dev/null 2>&1; do
    TRIES=$((TRIES + 1))
    if [ "$TRIES" -ge "$MAX_TRIES" ]; then
        echo "[start] ERROR: Database did not become ready after $MAX_TRIES attempts. Aborting."
        exit 1
    fi
    echo "[start] Database not ready yet (attempt $TRIES/$MAX_TRIES). Retrying in 2s..."
    sleep 2
done

echo "[start] Database is ready."

echo "[start] Caching config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[start] Running migrations..."
php artisan migrate --force
if [ $? -ne 0 ]; then
    echo "[start] ERROR: Migrations failed. Aborting."
    exit 1
fi
echo "[start] Migrations complete."

echo "[start] Starting Laravel server on 0.0.0.0:${PORT:-8080}..."
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
