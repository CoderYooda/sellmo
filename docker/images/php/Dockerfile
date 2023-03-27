FROM composer:latest AS composer

FROM php:8.2-fpm as php-base

MAINTAINER CoderYooda <CoderYooda@gmail.com>

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	    libpng-dev \
	    libonig-dev \
	    libzip-dev \
	    libmcrypt-dev

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis


ADD /docker/images/php/php.ini /usr/local/etc/php/conf.d/sellmo-php.ini

#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /application

#RUN chown -R www-data:www-data /application

FROM php-base AS base

WORKDIR /application

CMD ["php-fpm"]
