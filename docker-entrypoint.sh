#!/bin/sh
set -e

PORT="${PORT:-80}"

printenv | grep -E "^(APP_|DB_|MAIL_|CORS_|VITE_)" > /var/www/html/.env

echo "=== Cached view content ==="
cat /var/www/html/storage/cache/views/cbc0733501a0992e60caea281ab7cd9b.php 2>/dev/null || echo "FILE NOT FOUND"

sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/*.conf

exec apache2-foreground