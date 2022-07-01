FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
        libzip-dev

RUN pecl install zip \
    && docker-php-ext-enable zip \
    && docker-php-ext-install pdo_mysql

RUN a2enmod rewrite

COPY etc/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY etc/ssl/certificate.crt /etc/ssl/certificate.crt
COPY etc/ssl/ca_bundle.crt /etc/ssl/ca_bundle.crt
COPY etc/ssl/private/private.key /etc/ssl/private/private.key

RUN a2enmod ssl

WORKDIR /var/www/html

