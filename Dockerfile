# Use official PHP 8.1 FPM image
FROM php:8.1-fpm

# Install PHP extensions you may need, e.g. mysqli and pdo_mysql for MySQL
RUN docker-php-ext-install mysqli pdo_mysql

# Copy app files into container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Adjust permissions if needed (optional)
RUN chown -R www-data:www-data /var/www/html
