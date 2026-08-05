FROM php:8.4-fpm

ENV WORKDIR=/var/www \
    USER=www-data \
    GROUP=www-data

WORKDIR $WORKDIR

# Install system dependencies and Node.js/NPM
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configure & Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    opcache

# Copy Composer binary
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set directory permissions
RUN chown -R $USER:$GROUP $WORKDIR

USER $USER

EXPOSE 9000

CMD ["php-fpm"]