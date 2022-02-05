FROM php:8.1-apache
WORKDIR /var/www/html
COPY . /var/www/html

# Enable .htaccess
RUN a2enmod rewrite

# Apache config document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install extensions PHP (PERL)
RUN docker-php-ext-install pdo_mysql

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Create user in Docker
RUN useradd -ms /bin/bash userdocker
USER userdocker

# Install composer
RUN composer install