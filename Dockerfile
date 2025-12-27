FROM php:8.2.4-apache

# Install system dependencies (no recommends) and clean up apt cache
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       libpng-dev \
       libjpeg62-turbo-dev \
       libfreetype6-dev \
       libzip-dev \
       zlib1g-dev \
       unzip \
       curl \
       pkg-config \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions - install core first, then GD
RUN docker-php-ext-install -j$(nproc) pdo_mysql mysqli mbstring opcache zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

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

# Set environment variables
ENV APACHE_RUN_USER=www-data \
    APACHE_RUN_GROUP=www-data \
    APACHE_LOG_DIR=/var/log/apache2 \
    APACHE_PID_FILE=/var/run/apache2.pid \
    APACHE_RUN_DIR=/var/run/apache2 \
    APACHE_LOCK_DIR=/var/lock/apache2

# Enable Apache MPM module and set up for dynamic port
RUN a2dismod mpm_prefork && a2enmod mpm_worker

# Update Apache to listen on PORT environment variable
RUN echo 'Listen ${PORT:-80}' > /etc/apache2/ports.conf

EXPOSE ${PORT:-80}

CMD ["apache2-foreground"]