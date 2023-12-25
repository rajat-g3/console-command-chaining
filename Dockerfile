# Dockerfile
FROM php:7.2-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    unzip

RUN docker-php-ext-install pdo_mysql zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]
