FROM php:8.3

RUN apt-get update && apt-get install -y \
# On installe le package postgresql pour pouvoir utiliser postgresql avec php
    libpq-dev \
# On installe le PDO et le drive postgreSQL pour pouvoir utiliser notre BDD postgres avec PDO
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
