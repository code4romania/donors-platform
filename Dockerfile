FROM node:16-alpine as assets

WORKDIR /build

COPY app app
COPY resources resources
COPY \
    artisan \
    package.json \
    package-lock.json \
    tailwind.config.js \
    webpack.mix.js \
    ./

RUN npm ci --no-audit --ignore-scripts
RUN npm run production

FROM php:8.1-fpm-alpine

ARG S6_OVERLAY_VERSION=3.1.2.1

ADD https://github.com/just-containers/s6-overlay/releases/download/v${S6_OVERLAY_VERSION}/s6-overlay-noarch.tar.xz /tmp
RUN tar -C / -Jxpf /tmp/s6-overlay-noarch.tar.xz
ADD https://github.com/just-containers/s6-overlay/releases/download/v${S6_OVERLAY_VERSION}/s6-overlay-x86_64.tar.xz /tmp
RUN tar -C / -Jxpf /tmp/s6-overlay-x86_64.tar.xz

ENTRYPOINT ["/init"]

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/s6-rc.d /etc/s6-overlay/s6-rc.d

RUN apk update && \
    # production dependencies
    apk add --no-cache \
    nginx && \
    #
    # install extensions
    install-php-extensions \
    bcmath \
    gd \
    intl \
    pdo_mysql \
    redis \
    zip

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_CACHE_DIR /dev/null

WORKDIR /var/www

COPY --chown=www-data:www-data . /var/www
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=assets --chown=www-data:www-data /build/public/assets /var/www/public/assets
COPY --from=assets --chown=www-data:www-data /build/public/mix-manifest.json /var/www/public/mix-manifest.json

RUN composer install \
    --optimize-autoloader \
    --no-interaction \
    --no-plugins \
    --no-dev \
    --prefer-dist

ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

ENV S6_CMD_WAIT_FOR_SERVICES_MAXTIME 0

EXPOSE 80
