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
# STAGE 2: Opisyal na FrankenPHP Image (Production-Grade)
# ==========================================
FROM dunglas/frankenphp:1-alpine

# Mag-install ng unzip para sa Composer at mga karaniwang PHP extensions
RUN apk add --no-cache unzip libzip-dev && \
    docker-php-ext-install zip

WORKDIR /app

# I-copy ang Composer mula sa opisyal na image nito
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# I-copy ang composer files para sa layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# I-copy ang buong source code ng iyong project
COPY . .

# I-copy ang naging produkto ng Vite build mula sa Stage 1 papuntang public/build
COPY --from=frontend-builder /build/public/build ./public/build

# SIGURADUHIN ANG PERMISSIONS:
# 1. Bigyan ng permission ang FrankenPHP binary
# 2. Siguraduhing may karapatan ang PHP na magsulat sa storage folder para sa cache/logs
RUN chmod +x /usr/local/bin/frankenphp && \
    chmod -R 775 storage

# I-set ang port para sa Render (Dapat tugma sa port ng container)
ENV PORT=8080
EXPOSE 8080

# Ang tamang command para sa opisyal na FrankenPHP Server
CMD ["frankenphp", "php-server", "--listen", ":8080", "--root", "public/"]