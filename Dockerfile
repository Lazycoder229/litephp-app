# ==========================================
# STAGE 1: Node.js para sa Vite Compilation
# ==========================================
FROM node:20-alpine AS frontend-builder
WORKDIR /build
COPY package*.json ./
RUN npm ci
COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm run build

# ==========================================
# STAGE 2: PHP-Apache (Production-Ready)
# ==========================================
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

RUN mkdir -p storage/framework/sessions storage/cache/views storage/logs storage/uploads && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
CMD ["/usr/local/bin/docker-entrypoint.sh"]