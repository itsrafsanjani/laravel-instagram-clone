FROM php:8.0-fpm

WORKDIR /var/www/app

RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    libgmp-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxml2-dev \
    libxpm-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-xpm
RUN docker-php-ext-install pdo pdo_mysql bcmath gmp gd exif

RUN apt-get --no-install-recommends --yes install nodejs npm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

RUN chmod 777 -R /var/www/app
