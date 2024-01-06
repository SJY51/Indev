FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    nano \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    wget

RUN apt-get update && apt-get install -y zlib1g-dev libpng-dev libzip-dev\
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mysqli exif && docker-php-ext-enable mysqli && docker-php-ext-install zip

RUN a2enmod rewrite


ENV APACHE_DOCUMENT_ROOT /var/www/html

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache \
    && apt-get install -y ffmpeg
#    && pecl install -o -f redis \
#    &&  rm -rf /tmp/pear \
#    &&  docker-php-ext-enable redis

RUN apt update && apt install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libwebp-dev \
        libpng-dev && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg && \
    docker-php-ext-install gd

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick
RUN docker-php-ext-install bcmath
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy web services' files
COPY --chown=www-data:www-data ./ /var/www/html
#COPY --from=build /app .
