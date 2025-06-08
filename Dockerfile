# ---- Dockerfile for Enhanced Comment System (SQLite demo) ----
FROM php:8.2-apache

# ------------------------------------------------------------------
# 1) add SQLite headers, build PDO + PDO_SQLITE, then clean up
# ------------------------------------------------------------------
RUN set -ex \
    && apt-get update \
    && apt-get install -y --no-install-recommends sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get purge -y --auto-remove libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# ------------------------------------------------------------------
# 2) copy project into container
#    (assumes public/, src/, config/, storage/ are in repo root)
# ------------------------------------------------------------------
COPY . /var/www/html/

RUN mkdir -p /var/www/html/storage && chown -R www-data:www-data /var/www/html/storage

# ------------------------------------------------------------------
# 3) set correct permissions for SQLite file/folder
# ------------------------------------------------------------------
RUN chown -R www-data:www-data /var/www/html/storage

# ------------------------------------------------------------------
# 4) make “public/” the web root so URLs work without /public prefix
# ------------------------------------------------------------------
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/*.conf \
        /etc/apache2/apache2.conf \
        /etc/apache2/conf-available/*.conf

# (optional) enable mod_rewrite for pretty URLs in the future
RUN a2enmod rewrite
