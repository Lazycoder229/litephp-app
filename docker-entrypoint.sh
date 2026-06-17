#!/bin/sh
set -e

PORT="${PORT:-80}"

printenv | grep -E "^(APP_|DB_|MAIL_|CORS_|VITE_)" > /var/www/html/.env

# Clear view cache at itakda ang tamang permissions
rm -rf /var/www/html/storage/cache/views/
mkdir -p /var/www/html/storage/cache/views/
chown -R www-data:www-data /var/www/html/storage/
chmod -R 775 /var/www/html/storage/

sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/*.conf

exec apache2-foreground