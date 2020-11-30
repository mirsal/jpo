# Stage 0:. Install
FROM php:7.4-fpm-alpine as base

RUN apk add --update \
        acl \
        autoconf \
        curl \
        g++ \
        make \
        openssl \
        libxml2-dev \
        postgresql-dev \
        libssh2-dev \
        libzip-dev \
    && docker-php-ext-install pdo mysqli xmlrpc pdo_mysql pgsql pdo_pgsql zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && pecl install ssh2-1.2 \
    && docker-php-ext-enable ssh2 \
    && apk del \
		autoconf \
		g++

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    ln -s $(composer config --global home) /root/composer

RUN rm -rf /tmp/* /var/cache/apk/*
ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /var/www/app
EXPOSE 9000

CMD ["php-fpm", "-F"]


# Stage 1: Build
FROM base as build

## Copy App files
COPY composer.json composer.lock symfony.lock .env* ./
COPY bin bin/
COPY config config/
COPY migrations migrations/
COPY public public/
COPY src src/
COPY templates templates/

## Install App dependencies (using composer in PROD env)
ARG APP_ENV=prod
ENV APP_ENV ${APP_ENV}
RUN set -eux; \
    composer install --no-dev --no-scripts --no-suggest --no-interaction --prefer-dist --optimize-autoloader; \
    composer dump-autoload --no-dev --optimize --classmap-authoritative;


# Stage 2: Dev
FROM base as dev

## Copy App files
COPY composer.json composer.lock symfony.lock .env* ./
COPY bin bin/
COPY config config/
COPY migrations migrations/
COPY public public/
COPY src src/
COPY templates templates/

## Set execution mod on App console binary
RUN chmod +x /var/www/app/bin/console; sync

ARG APP_ENV=dev
ENV APP_ENV ${APP_ENV}

ARG APP_VERSION=development
ENV APP_VERSION ${APP_VERSION}

## Install App dependencies
RUN set -eux; \
    composer install --prefer-dist --no-progress --no-suggest;

# Clean var cache and log files
RUN set -eux; \
    rm -rf /var/www/app/var/cache /var/www/app/var/log; \
    mkdir -p /var/www/app/var/cache /var/www/app/var/log; \
    chmod 0755 /var/www/app/var/cache /var/www/app/var/log; \
    chown www-data:www-data /var/www/app/var/cache /var/www/app/var/log;

# Define volumes
VOLUME /var/www/app/var/cache
VOLUME /tmp


# Stage 3: Prod
FROM base as prod

## Copy App files
COPY composer.json composer.lock symfony.lock .env ./
COPY bin bin/
COPY config config/
COPY migrations migrations/
COPY public public/
COPY src src/
COPY templates templates/

## Set execution mod on App console binary
RUN chmod +x /var/www/app/bin/console; sync

ARG APP_ENV=prod
ENV APP_ENV ${APP_ENV}

ARG APP_VERSION=production
ENV APP_VERSION ${APP_VERSION}

## Copy built vendors
COPY --from=build /var/www/app/vendor /var/www/app/vendor

# Clean var cache and log files
RUN set -eux; \
    mkdir -p /var/www/app/var/cache /var/www/app/var/log; \
    chmod 0755 /var/www/app/var/cache /var/www/app/var/log; \
    chown www-data:www-data /var/www/app/var/cache /var/www/app/var/log;

# Define volumes
VOLUME /var/www/app/var/cache
VOLUME /tmp
