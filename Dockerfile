# ---- Dockerfile (копируйте как есть) ----
FROM php:8.2-apache

# Включить расширения, нужные скрипту
RUN docker-php-ext-install pdo pdo_sqlite

# Скопировать проект в DocumentRoot
COPY . /var/www/html/

# Настроить права папки storage (SQLite)
RUN chown -R www-data:www-data /var/www/html/storage

# Включить Apache mod_rewrite (для красивых URL, если захотите)
RUN a2enmod rewrite
