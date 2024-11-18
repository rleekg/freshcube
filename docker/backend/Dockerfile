FROM php:8.3.13-fpm AS base

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Установка PHP Extension Installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git

RUN install-php-extensions zip


# Создание пользователя
RUN groupadd --gid 1000 user && \
    useradd --uid 1000 --gid user --shell /bin/bash --create-home user

RUN su user -c 'mkdir -p /home/user/.composer/'

# Dev образ для разработки
FROM base AS dev

USER root

# Установка Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Копирование конфигураций PHP
COPY php/conf.d /usr/local/etc/php/conf.d
COPY php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Установка рабочей директории
WORKDIR /app/

# Переключение на пользователя
USER user
