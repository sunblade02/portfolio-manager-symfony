ARG PHP_IMAGE_TAG=8.3-alpine
ARG COMPOSER_IMAGE_TAG=2.8
ARG PHP_EXTENSION_INSTALLER_IMAGE_TAG=2.8
ARG NODE_IMAGE_TAG=24-alpine

FROM composer:${COMPOSER_IMAGE_TAG} AS composer
FROM mlocati/php-extension-installer:${PHP_EXTENSION_INSTALLER_IMAGE_TAG} AS php_extension_installer
FROM node:${NODE_IMAGE_TAG} AS node
FROM php:${PHP_IMAGE_TAG}

COPY --from=composer /usr/bin/composer /usr/local/bin
COPY --from=php_extension_installer /usr/bin/install-php-extensions /usr/local/bin
COPY --from=node /usr/local/bin /usr/local/bin
COPY --from=node /usr/local/lib /usr/local/lib
COPY --from=node /opt /opt

RUN install-php-extensions \
    xdebug \
    apcu \
    intl \
    pdo_mysql