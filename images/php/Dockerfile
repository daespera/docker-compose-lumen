FROM php:fpm
RUN apt-get update && apt-get install -y libmcrypt-dev

# lumen packages
RUN apt-get install -y memcached php5-memcached php5-memcache libmemcached11 libmemcachedutil2 build-essential libmemcached-dev libz-dev 
RUN docker-php-ext-install mcrypt mbstring tokenizer pdo pdo_mysql
RUN pecl install apcu memcached && \
	echo 'extension = apcu.so' > /usr/local/etc/php/conf.d/apcu.ini && \
	echo 'extension = memcached.so' > /usr/local/etc/php/conf.d/memcached.ini
RUN apt-get update && apt-get install -y libmemcached-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached