FROM php:8.0-fpm

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install --fix-missing -y \
     libzip-dev libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
     libfreetype6-dev libmagickwand-dev libgmp-dev libldap2-dev \
     git zip libsqlite3-dev curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl

RUN docker-php-ext-configure bz2
RUN docker-php-ext-install bz2

RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Change current user to www
USER www

CMD ["php-fpm"]
