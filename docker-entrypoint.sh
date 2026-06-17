#!/bin/sh
set -e

PORT="${PORT:-80}"

printenv | grep -E "^(APP_|DB_|MAIL_|CORS_|VITE_|SESSION_|VIEW_)" > /var/www/html/.env

sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" \
    /etc/apache2/sites-available/*.conf

exec apache2-foreground