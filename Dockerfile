FROM php:8.2.4-apache

# Install system dependencies (no recommends) and clean up apt cache
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       libpng-dev \
       libjpeg-dev \
       libfreetype6-dev \
       libzip-dev \
       zlib1g-dev \
       unzip \
       curl \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions (in correct order)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql mysqli gd zip mbstring opcache

# PHP recommended settings
COPY docker/php/conf.d/zz-opcache.ini /usr/local/etc/php/conf.d/zz-opcache.ini
COPY docker/php/conf.d/zz-custom.ini /usr/local/etc/php/conf.d/zz-custom.ini

# Apache configuration
COPY docker/apache/conf.d/app.conf /etc/apache2/conf-available/app.conf

# Enable useful Apache modules and allow .htaccess overrides
RUN a2enmod rewrite headers \
    && a2enconf app \
    && sed -ri 's/AllowOverride\s+None/AllowOverride All/g' /etc/apache2/apache2.conf \
    && sed -ri 's/<Directory \/var\/www\/html>/<Directory \/var\/www\/html>\n    Options -MultiViews -Indexes/g' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy application files (overridden by volume in docker-compose for dev)
COPY ./src /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
