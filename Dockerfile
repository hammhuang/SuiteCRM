FROM php:7.3-apache

# install all the system dependencies and enable PHP modules
RUN apt-get update && apt-get install -y \
      libicu-dev \
      libonig-dev \
      libpq-dev \
      libzip-dev \
      libmcrypt-dev \
      git \
      zip \
      unzip \
      libxml2-dev \
      zlib1g-dev \
      libpng-dev \
      libc-client-dev \
      libkrb5-dev \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install \
      imap \
      mysqli \
      fileinfo \
      intl \
      mbstring \
      pcntl \
      pdo_mysql \
      pdo_pgsql \
      pgsql \
      zip \
      opcache \
      soap \
      gd

RUN pecl install mcrypt-1.0.3 && docker-php-ext-enable mcrypt
RUN pecl install xdebug && docker-php-ext-enable xdebug

# RUN pecl install redis && docker-php-ext-enable redis

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --version=1.10.16 --install-dir=/usr/bin/ --filename=composer

# install global parallel download helper
RUN composer global require hirak/prestissimo

# set our application folder as an environment variable
ENV APP_HOME /var/www/html

# change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# apache log to stdout stderr
RUN echo "ErrorLog /dev/stderr" >> /etc/apache2/sites-enabled/000-default.conf
RUN echo "TransferLog /dev/stdout" >> /etc/apache2/sites-enabled/000-default.conf
RUN echo 'LogFormat "%{X-Forwarded-For}i %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" combined' > /etc/apache2/conf-enabled/override-combined.conf

# enable apache module rewrite
RUN a2enmod rewrite

# copy source files and run composer
COPY . $APP_HOME

# install all PHP dependencies

RUN composer install --no-interaction
# change ownership of our applications
RUN chown -R www-data:www-data $APP_HOME
RUN chmod -R 755 $APP_HOME/.
