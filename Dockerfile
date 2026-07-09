# ──────────────────────────────────────────────────────────────────────────
# Stage 1: Build frontend assets (Vite + Tailwind)
# ──────────────────────────────────────────────────────────────────────────
FROM node:20-alpine AS frontend-builder
WORKDIR /build

COPY package*.json ./
RUN npm ci

COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/

COPY app/views/ ./app/views/

RUN npm run build

# ──────────────────────────────────────────────────────────────────────────
# Stage 2: PHP runtime
# ──────────────────────────────────────────────────────────────────────────
FROM php:8.3-apache

RUN apt-get update && \
    apt-get install -y --no-install-recommends unzip libzip-dev && \
    docker-php-ext-install zip && \
    a2enmod rewrite && \
    apt-get clean && \
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

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
CMD ["/usr/local/bin/docker-entrypoint.sh"]