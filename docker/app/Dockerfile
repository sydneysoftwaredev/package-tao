FROM joeniland/laravel-ci:8.1-20240612 AS BUILD_PACKAGE

WORKDIR /buildapp

COPY composer.json composer.lock ./

ENV COMPOSER_NO_DEV=1

RUN composer --version && \
    composer install --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts && \
    composer dump-autoload --optimize

# Get spx for profiling
WORKDIR /tmp
RUN git clone https://github.com/NoiseByNorthwest/php-spx.git && \
    cd php-spx && \
    git checkout release/latest

# Build our image from the base image created by OAT
FROM local/phpfpm:latest

COPY --from=BUILD_PACKAGE /buildapp/vendor /var/www/html/vendor

# Xdebug

RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

COPY docker/app/conf/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Xdebug profile storage
RUN mkdir -p /tmp/profiles && \
    chown www-data:www-data /tmp/profiles

# spx for profiling
COPY --from=BUILD_PACKAGE /tmp/php-spx /tmp/php-spx
WORKDIR /tmp/php-spx
RUN apt-get install -y zlib1g-dev && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    rm -rf /tmp/php-spx
COPY docker/app/conf/spx.ini /usr/local/etc/php/conf.d/spx.ini

# Clean pear cache
RUN rm -r /tmp/pear

WORKDIR /var/www/html