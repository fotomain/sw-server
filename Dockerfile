# Use an official PHP runtime as a parent image
FROM php:8.1-apache

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the PHP file into the container's web directory
COPY /app/html/ /var/www/html/

# Set the ServerName to suppress the warning about Apache's domain name
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Enable mod_rewrite for Apache (optional, useful for many PHP applications)
RUN a2enmod rewrite

RUN a2enmod headers

RUN sed -ri -e 's/^([ \t]*)(<\/VirtualHost>)/\1\tHeader set Access-Control-Allow-Origin "*"\n\1\2/g' /etc/apache2/sites-available/*.conf


