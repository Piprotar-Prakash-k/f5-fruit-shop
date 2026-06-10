FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    zip unzip curl git nodejs npm \
    libzip-dev libicu-dev libxml2-dev \
    libonig-dev \
    && docker-php-ext-install pdo_mysql zip intl mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html/storage

COPY start.sh /var/www/html/start.sh
RUN chmod +x /var/www/html/start.sh

EXPOSE 8080

CMD ["bash", "start.sh"]