FROM php:8.2-apache

# 1️⃣ Instalar PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# 2️⃣ Habilitar mod_rewrite
RUN a2enmod rewrite

# 3️⃣ Configurar DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4️⃣ Copiar el código del proyecto
COPY . /var/www/html/

# 5️⃣ Permisos
RUN chown -R www-data:www-data /var/www/html

# 6️⃣ Copiar entrypoint para puerto dinámico
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 7️⃣ Usar el entrypoint
CMD ["docker-entrypoint.sh"]