FROM php:8.1-apache

# Define variables
ARG WORKDIR=/var/www/html
ARG DOCUMENT_ROOT=${WORKDIR}
ARG USER=docker
ARG UID=1000

# Enable .htaccess
RUN a2enmod rewrite

# Apache config document root
ENV APACHE_DOCUMENT_ROOT=${DOCUMENT_ROOT}
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install extensions PHP (PERL)
RUN docker-php-ext-install pdo_mysql

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Create user in Docker
RUN useradd -G www-data,root -u ${UID} -d /home/${USER} ${USER}

# Set working directory and user
WORKDIR ${WORKDIR}
USER ${USER}