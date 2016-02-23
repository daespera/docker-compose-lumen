FROM php:fpm
RUN apt-get update && apt-get install -y libmcrypt-dev git

RUN apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# lumen packages

RUN docker-php-ext-install mcrypt mbstring tokenizer pdo pdo_mysql

RUN apt-get install -y libmemcached-dev \
    && cd /tmp \
    && git clone -b php7 https://github.com/php-memcached-dev/php-memcached.git \
    && cd php-memcached \
    && phpize \
    && ./configure \
    && make \
    && echo "extension=/tmp/php-memcached/modules/memcached.so" > /usr/local/etc/php/conf.d/memcached.ini