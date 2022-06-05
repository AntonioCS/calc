ARG PHP_VERSION=8.1.6-fpm-buster
FROM php:${PHP_VERSION} as image_base

RUN rm /etc/apt/preferences.d/no-debian-php && \
    apt-get update && \
    apt-get install -y --no-install-recommends --fix-missing \
        libzip-dev \
        zip \
        unzip \
        git \
        libssh2-1-dev \
        ssh-client \
        libicu-dev \
        acl \
        procps \
        # PHP
        php-pear && \
    apt-get clean && \
    docker-php-ext-configure \
        intl && \
    docker-php-ext-install -j$(nproc) \
        intl \
        zip && \
    rm -rf \
        /var/cache/apt/archives/* \
        /var/lib/apt/lists/* \
        /tmp/* \
        /var/tmp/* \
        /var/lib/apt/lists/* \
        /var/www/html \
        /usr/local/src/*

WORKDIR /var/www/project
COPY --from=composer:latest /usr/bin/composer /usr/bin/

FROM image_base as image_dev
ARG XDEBUG_VERSION=3.1.4
RUN apt-get update && apt-get install -y --no-install-recommends jq && \
    yes '' | pecl install -o -f xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
ENV COMPOSER_ALLOW_SUPERUSER=1
CMD php-fpm
