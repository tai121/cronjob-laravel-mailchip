# First Stage
FROM php:8.2-fpm-alpine as builder

WORKDIR /var/www/html

RUN set -eux; \
    apk --no-cache add git unzip libzip-dev; \
    docker-php-ext-install pdo pdo_mysql zip; \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    apk del git unzip libzip-dev; \
    rm -rf /var/cache/apk/*

COPY . .

RUN composer install --ignore-platform-req=ext-curl 

# Second Stage
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

COPY --from=builder /var/www/html /var/www/html

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
