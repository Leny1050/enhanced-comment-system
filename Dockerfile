# ---- базовый образ с PHP 8.2 и SQLite ----
FROM php:8.2-cli

# Включаем расширения pdo_sqlite и pdo_mysql (на будущее)
RUN docker-php-ext-install pdo pdo_sqlite pdo_mysql

WORKDIR /app
COPY . .

# Render прокидывает порт 10000 по умолчанию
EXPOSE 10000
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
