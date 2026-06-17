#!/bin/sh
set -e

PORT="${PORT:-80}"

# I-generate ang .env mula sa system environment
printenv | grep -E "^(APP_|DB_|MAIL_|CORS_|VITE_)" > /var/www/html/.env

# I-clear ang stale view cache
rm -rf /var/www/html/storage/cache/views/*

# Debug: i-check kung nandoon ang manifest
echo "=== Checking Vite manifest ==="
find /var/www/html/public/build -name "manifest.json" 2>/dev/null || echo "NO MANIFEST FOUND"
ls -la /var/www/html/public/build/ 2>/dev/null || echo "public/build/ does not exist"

sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/*.conf

exec apache2-foreground