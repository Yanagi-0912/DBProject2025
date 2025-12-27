FROM php:8.2.4-apache

# Install system dependencies (no recommends) and clean up apt cache
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       libpng-dev \
       libjpeg-dev \
       libfreetype6-dev \
       libzip-dev \
       unzip \
       curl \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
       pdo \
       pdo_mysql \
       mysqli \
       gd \
       zip \
       mbstring \
       opcache

# PHP recommended settings
COPY docker/php/conf.d/zz-opcache.ini /usr/local/etc/php/conf.d/zz-opcache.ini
COPY docker/php/conf.d/zz-custom.ini /usr/local/etc/php/conf.d/zz-custom.ini

# Enable useful Apache modules and allow .htaccess overrides
RUN a2enmod rewrite headers \
    && sed -ri 's/AllowOverride\s+None/AllowOverride All/g' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy application files (overridden by volume in docker-compose for dev)
COPY ./src /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
