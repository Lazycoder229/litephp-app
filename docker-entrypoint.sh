#!/bin/sh
set -e

PORT="${PORT:-80}"

printenv | grep -E "^(APP_|DB_|MAIL_|CORS_|VITE_)" > /var/www/html/.env

# I-patch ang APP_BASE_PATH sa vendor helpers
sed -i "s|dirname(__DIR__)|'/var/www/html'|g" \
    /var/www/html/vendor/litephp/core/Core/helpers.php

sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" \
    /etc/apache2/sites-available/*.conf

exec apache2-foreground