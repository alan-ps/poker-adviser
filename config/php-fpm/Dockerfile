FROM php:7.1-fpm-alpine

RUN set -ex \
    && apk add --no-cache --virtual .build-deps \
        g++ \
        make \
        autoconf \
        coreutils

# Setup the xDebug version to install.
ENV XDEBUG_VERSION 2.6.0

# Install xDebug.
RUN set -x && \
    curl -SL "http://www.xdebug.org/files/xdebug-$XDEBUG_VERSION.tgz" -o xdebug.tgz && \
    mkdir -p /usr/src/xdebug && \
    tar -xf xdebug.tgz -C /usr/src/xdebug --strip-components=1 && \
    rm xdebug.* && \
    cd /usr/src/xdebug && \
    phpize && \
    ./configure && \
    make -j"$(nproc)" && \
    make install && \
    make clean

COPY ./ext-xdebug.ini /usr/local/etc/php/conf.d/ext-xdebug.ini
RUN apk del .build-deps

WORKDIR /var/www/html
