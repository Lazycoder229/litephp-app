FROM php:8.3-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y unzip curl nodejs npm && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install --no-dev --optimize-autoloader && \
    npm install && npm run build

    
EXPOSE 8080
CMD ["/bin/sh", "-c", "env | grep -E '^(APP_|DB_|SESSION_|MAIL_|CORS_|VITE_)' > .env && php -S 0.0.0.0:${PORT:-8080} -t . router.php"]