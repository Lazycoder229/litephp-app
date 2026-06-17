#!/bin/sh
set -e

PORT="${PORT:-80}"

printenv | grep -E "^(APP_|DB_|MAIL_|CORS_|VITE_)" > /var/www/html/.env

# Clear stale view cache
rm -rf /var/www/html/storage/cache/views/
mkdir -p /var/www/html/storage/cache/views/

echo "=== .vite folder contents ==="
ls -la /var/www/html/public/build/.vite/ 2>/dev/null || echo "NO .vite FOLDER"

sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/*.conf

exec apache2-foreground