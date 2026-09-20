FROM php:8.5-fpm-alpine

ARG UID=1000
ARG GID=1000

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
        bash \
        git \
        curl \
        libzip-dev \
        shadow \
    && usermod -u ${UID} www-data \
    && groupmod -g ${GID} www-data \
    && docker-php-ext-install \
        pdo_mysql

# OPcache settings
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
    && echo "opcache.revalidate_freq=0" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
    && echo "opcache.validate_timestamps=1" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
