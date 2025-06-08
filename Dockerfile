FROM php:8.2-apache

# 1) докачиваем dev-пакеты sqlite3
# 2) компилируем pdo и pdo_sqlite
# 3) чистим apt кеш, чтобы образ был меньше
RUN set -ex \
    && apt-get update \
    && apt-get install -y --no-install-recommends sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get purge -y --auto-remove libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# копируем ваш проект
COPY . /var/www/html/

# права на папку storage (SQLite-файл)
RUN chown -R www-data:www-data /var/www/html/storage

# если хотите красивые URL в будущем
RUN a2enmod rewrite
