# I-build  Frontend (Vite)
FROM node:20-alpine AS frontend-builder
WORKDIR /build
COPY package*.json ./
RUN npm ci
COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm run build

#  FrankenPHP Server Production (Single Container)
FROM dunglas/frankenphp:1.1-alpine

# install extensions 
RUN apk add --no-cache unzip

WORKDIR /app

# copy a Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# copy  app
COPY . .


COPY --from=frontend-builder /build/public/build ./public/build


ENV SERVER_NAME=:8080
CMD ["frankenphp", "php-server", "--root", "public/"]