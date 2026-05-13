FROM php:8.3-apache

# Installing security mod
RUN apt-get update && \
    apt-get install -y \
    libapache2-mod-security2 libzip-dev zip && \
    rm -rf /var/lib/apt/lists/*

# Extensions PHP courantes
RUN docker-php-ext-install pdo pdo_mysql mysqli zip

# Activation des mod Apache utiles
RUN a2enmod rewrite security2 headers

# Virtual host personnalisé
COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Security measures for apache
COPY docker/apache/security.conf /etc/apache2/conf-available/security.conf

# PHP config
COPY docker/php/php.ini /usr/local/etc/php/

# Special script to make it possible for www-data group to have write
# access in /var/www/tmp and uploads folders.
RUN printf '#!/bin/bash\nHOST_UID=$(stat -c "%%u" /var/www/storage)\nusermod -u $HOST_UID www-data 2>/dev/null\nexec apache2-foreground\n' > /entrypoint.sh && \
    chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

WORKDIR /var/www/public