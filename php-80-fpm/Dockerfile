# Are there more modules needed? https://github.com/cocoastorm/dockerfiles/blob/master/apache-php-essential/Dockerfile

FROM php:8.0-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    golang-go

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Redis
RUN pecl install redis && docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install MailHog
RUN go get github.com/mailhog/mhsendmail && cp /root/go/bin/mhsendmail /usr/local/bin/mhsendmail

# Copy in the php.ini
COPY ./php-8.0.ini /usr/local/etc/php/php.ini