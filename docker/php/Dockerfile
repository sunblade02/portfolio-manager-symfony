ARG PHP_IMAGE_TAG=8.3-alpine
ARG COMPOSER_IMAGE_TAG=2.8
ARG PHP_EXTENSION_INSTALLER_IMAGE_TAG=2.8

FROM composer:${COMPOSER_IMAGE_TAG} AS composer
FROM mlocati/php-extension-installer:${PHP_EXTENSION_INSTALLER_IMAGE_TAG} AS php_extension_installer
FROM php:${PHP_IMAGE_TAG}

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=php_extension_installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    xdebug \
    apcu \
    intl