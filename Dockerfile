FROM php:8.2-fpm-alpine

# Sistem bağımlılıkları
RUN apk add --no-cache \
    bash \
    curl \
    git \
    zip \
    unzip \
    libzip-dev \
    oniguruma-dev \
    nodejs \
    npm \
    shadow \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    libxml2-dev \
    && docker-php-ext-configure gd \
      --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# Composer ekle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Proje dizini
WORKDIR /var/www

# Dosyaları kopyala (veya volume ile mount edilecek)
COPY . .

# Laravel için gerekli izinler
RUN chmod -R 775 storage bootstrap/cache

# Laravel için kullanıcı oluştur
RUN adduser -D laravel && chown -R laravel:laravel /var/www
USER laravel
