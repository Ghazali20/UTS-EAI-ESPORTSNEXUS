FROM php:8.2-fpm
WORKDIR /var/www
COPY . .
EXPOSE 9000
CMD ["php-fpm"]
