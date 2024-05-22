# FROM php:8.1.0-apache

# WORKDIR /var/www/html

# RUN a2enmod rewrite

# RUN apt-get update -y && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     vim



# # RUN apk --no-cache upgrade && \
# #     apk --no-cache add bash git sudo openssh  libxml2-dev oniguruma-dev autoconf gcc g++ make npm freetype-dev libjpeg-turbo-dev libpng-dev libzip-dev

# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# # PHP: Install php extensions
# RUN pecl channel-update pecl.php.net
# RUN pecl install swoole

# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd xml iconv

# # RUN docker-php-ext-install mbstring xml iconv pcntl gd zip sockets pdo  pdo_mysql bcmath soap
# # RUN docker-php-ext-configure gd --with-freetype --with-jpeg
# # RUN docker-php-ext-enable mbstring xml gd iconv zip pcntl sockets bcmath pdo  pdo_mysql soap swoole

# RUN docker-php-ext-install pdo pdo_mysql sockets
# RUN curl -sS https://getcomposer.org/installer​ | php -- \
#      --install-dir=/usr/local/bin --filename=composer

# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

# COPY . .

# RUN composer install
# RUN composer require laravel/octane spiral/roadrunner

# COPY .env.example .env

# RUN php artisan key:generate
# RUN php artisan octane:install --server="swoole"

# CMD php artisan octane:start --server="swoole" --host="0.0.0.0"
# EXPOSE 8000


FROM php:8.1

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=8000

