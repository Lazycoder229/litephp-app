FROM node:20-alpine AS frontend-builder
WORKDIR /build
COPY package*.json ./
RUN npm ci
COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm run build
RUN test -f /build/public/build/.vite/manifest.json || \
    test -f /build/public/build/manifest.json || \
    (echo "Vite manifest not found - build failed" && exit 1)
RUN echo "=== Built files ===" && find /build/public/build -type f

FROM php:8.3-apache

RUN apt-get update && apt-get install -y unzip libzip-dev && \
    docker-php-ext-install zip && \
    a2enmod rewrite && \
    rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

COPY --from=frontend-builder /build/public/build ./public/build

RUN sed -i "s/env('VITE_DEV', 'true')/env('VITE_DEV', 'false')/" \
        /var/www/html/vendor/litephp/core/Core/helpers.php && \
    sed -i \
    "s|public_path('build/.vite/manifest.json')|'/var/www/html/public/build/.vite/manifest.json'|g" \
    /var/www/html/vendor/litephp/core/Core/helpers.php && \
    sed -i \
    "s|public_path('build/manifest.json')|'/var/www/html/public/build/manifest.json'|g" \
    /var/www/html/vendor/litephp/core/Core/helpers.php

RUN echo "=== Verifying patches ===" && \
    grep "VITE_DEV\|isDev\|manifest" \
    /var/www/html/vendor/litephp/core/Core/helpers.php | head -10

RUN test -f /var/www/html/public/build/.vite/manifest.json || \
    test -f /var/www/html/public/build/manifest.json || \
    (echo "Manifest missing in final image" && exit 1) && \
    echo "Manifest confirmed in final image"

RUN rm -rf storage/cache/views/ && \
    mkdir -p storage/framework/sessions storage/cache/views storage/logs storage/uploads && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
CMD ["/usr/local/bin/docker-entrypoint.sh"]
