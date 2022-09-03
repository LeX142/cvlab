FROM composer:2 as composer

FROM php:8.1.9-fpm-alpine

LABEL Maintainer="Alexey Sidorov <github.com/lex142>" \
    Description="PHP-FPM v8.1.9 with essential extensions on top of Alpine Linux for."

ENV TZ=US/Eastern
ENV DEBIAN_FRONTEND="noninteractive"
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install dependencies
RUN set -eux \
    && apk update \
    && apk add --no-cache \
        c-client \
        ca-certificates \
        freetds \
        freetype \
        gettext \
        gmp \
        icu-libs \
        libgmpxx \
        libintl \
        libjpeg-turbo \
        libpng \
        libpq \
        libssh2 \
        libstdc++ \
        libtool \
        libxpm \
        libxslt \
        libzip \
        make \
        tidyhtml \
        tzdata \
        vips \
        rabbitmq-c \
        openssh \
        zip \
        yaml \
        git \
        curl \
        wget \
        bash
\
#############################################
### Install and enable PHP extensions
#############################################
\
# Development dependencies
RUN set -eux \
    && apk add --no-cache --virtual .build-deps \
        autoconf \
        automake \
        bzip2-dev \
        build-base \
        cmake \
        curl-dev \
        freetds-dev \
        freetype-dev \
        gawk \
        gcc \
        gettext-dev \
        git \
        gmp-dev \
        icu-dev \
        krb5-dev \
        libc-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libssh2-dev \
        libwebp-dev \
        libxml2-dev \
        libxpm-dev \
        libxslt-dev \
        libzip-dev \
        openssl-dev \
        pcre-dev \
        pkgconf \
        tidyhtml-dev \
        vips-dev \
        yaml-dev \
        zlib-dev \
        rabbitmq-c-dev \
        php8-dev \
\
################################
# Install PHP extensions
################################
\
# Install apcu
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && true \
\
# Install bcmath
    && docker-php-ext-install -j$(nproc) bcmath \
    && true \
\
# Install bz2
    && docker-php-ext-install -j$(nproc) bz2 \
    && true \
\
# Install exif
    && docker-php-ext-install -j$(nproc) exif \
    && true \
\
# Install intl
    && docker-php-ext-install -j$(nproc) intl \
    && true \
\
# Install mysqli
    && docker-php-ext-install -j$(nproc) mysqli \
    && true \
\
# Install pdo_mysql
    && docker-php-ext-configure pdo_mysql --with-zlib-dir=/usr \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && true \
\
# Install pcntl
    && docker-php-ext-install -j$(nproc) pcntl \
    && true \
\
# Install zip
    && docker-php-ext-install zip \
    && true \
\
# Install opcache
    && docker-php-ext-install opcache \
    && true \
\
# Install sockets
    && docker-php-ext-install sockets \
    && true \
\
# Install simplexml
    && docker-php-ext-install simplexml \
    && true \
\
# Install psr
    && pecl install psr \
    && docker-php-ext-enable psr \
    && true \
\
# Install amqp
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && true \
\
# Install redis
    && pecl install redis \
    && docker-php-ext-enable redis \
    && true \
\
# Install xdebug
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && true \
\
# Clean up build packages
    && docker-php-source delete \
    && apk del .build-deps \
    && true

RUN set -eux \
# Fix php.ini settings for enabled extensions
    && chmod +x "$(php -r 'echo ini_get("extension_dir");')"/* \
# Shrink binaries
    && (find /usr/local/bin -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
    && (find /usr/local/lib -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
    && (find /usr/local/sbin -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
    && ln -s /etc/ssl/cert.pem /etc/ssl/certs/cacert.pem \
    && mkdir -p /app/docker \
    && true

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

COPY *.conf /usr/local/etc/php-fpm.d/
COPY php.ini /usr/local/etc/php/php.ini
COPY xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

WORKDIR /app

EXPOSE 9000

#ENTRYPOINT ["/docker-entrypoint/docker-entrypoint.sh"]

