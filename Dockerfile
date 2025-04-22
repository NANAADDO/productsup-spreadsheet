FROM php:8.2-fpm

# Copy composer.lock composer.json
COPY appservice/composer.lock appservice/composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies, including required libraries for YAML and cURL
RUN apt-get update && apt-get install -y \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libcurl4-openssl-dev \
    libyaml-dev \
    freetds-bin freetds-dev freetds-common libct4 libsybdb5 tdsodbc libreadline-dev librecode-dev libpspell-dev libonig-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install required PHP extensions (including cURL)
RUN docker-php-ext-install curl pdo_dblib mbstring pdo_mysql

# Install and enable the YAML extension via PECL
RUN pecl install yaml \
    && docker-php-ext-enable yaml

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy composer files
COPY appservice/composer.lock appservice/composer.json /var/www/

# Copy application directory contents and set correct permissions
COPY --chown=www:www /appservice /var/www

# Change current user to www
USER www

# Expose the PHP-FPM port
EXPOSE 9000

# Start PHP-FPM when the container starts
CMD ["php-fpm"]