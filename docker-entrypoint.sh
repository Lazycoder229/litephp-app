#!/bin/sh
set -e

PORT="${PORT:-80}"

printenv | grep -E "^(APP_|DB_|MAIL_|CORS_|VITE_)" > /var/www/html/.env

echo "=== APP_BASE_PATH check ==="
php -r "define('APP_BASE_PATH', '/var/www/html'); echo 'public_path: ' . '/var/www/html/public/build/.vite/manifest.json' . PHP_EOL; echo 'exists: ' . (file_exists('/var/www/html/public/build/.vite/manifest.json') ? 'YES' : 'NO') . PHP_EOL;"

sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/*.conf

exec apache2-foreground