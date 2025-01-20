FROM php:8.3-fpm-alpine

# packages
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash
RUN apk add --update linux-headers

RUN pecl install xdebug-3.3.1 \
    && docker-php-ext-enable xdebug
ENV PHP_IDE_CONFIG 'serverName=test'

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

RUN docker-php-ext-install pdo mysqli
RUN docker-php-ext-enable pdo mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

