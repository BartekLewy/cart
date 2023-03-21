FROM php:8.2-fpm as php

RUN apt-get update \
    && apt-get install -y \
      libzip-dev \
      zip \
      git \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo pdo_mysql


ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /.composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
