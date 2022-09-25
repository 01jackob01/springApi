FROM ubuntu:20.04

# Install apache, PHP, MariaDb, LibreOffice
RUN apt-get update && apt-get -y upgrade
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install apache2
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install php7.4
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install php7.4-mbstring
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install php-curl
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install php-pear
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install php-dev

#Install xdebug
RUN apt-get install -y wget
RUN pecl install xdebug

# Enable apache mods
RUN a2enmod php7.4
RUN a2enmod rewrite

# Install Nano
RUN apt-get install -y mc nano

# Update the PHP.ini file
RUN sed -i "s/;extension=curl/extension=curl/g" /etc/php/7.4/apache2/php.ini

RUN echo "zend_extension='/usr/lib/php/20190902/xdebug.so'" >> /etc/php/7.4/apache2/php.ini
RUN echo "xdebug.mode=debug,develop" >> /etc/php/7.4/apache2/php.ini
RUN echo "xdebug.client_host=host.docker.internal" >> /etc/php/7.4/apache2/php.ini
RUN echo "xdebug.client_port=9003" >> /etc/php/7.4/apache2/php.ini
RUN echo "xdebug.start_with_request=yes" >> /etc/php/7.4/apache2/php.ini

RUN sed -i "s/;extension=curl/extension=curl/g" /etc/php/7.4/cli/php.ini

RUN echo "zend_extension='/usr/lib/php/20190902/xdebug.so'" >> /etc/php/7.4/cli/php.ini
RUN echo "xdebug.mode=debug,develop" >> /etc/php/7.4/cli/php.ini
RUN echo "xdebug.client_host=host.docker.internal" >> /etc/php/7.4/cli/php.ini
RUN echo "xdebug.client_port=9003" >> /etc/php/7.4/cli/php.ini
RUN echo "xdebug.start_with_request=yes" >> /etc/php/7.4/cli/php.ini

# Manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Expose apache
EXPOSE 9003
EXPOSE 80

# Enable xdebug
ENV PHP_XDEBUG_ENABLED: 1

# By default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/apache2ctl -D FOREGROUND && bash -c "composer install --working-dir=/var/www/html"