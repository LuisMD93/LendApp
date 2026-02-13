FROM php:8.2-apache

# 1. Instalar dependencias para PostgreSQL (Cambiamos libmariadb por libpq)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# 2. Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# 3. Configurar el DocumentRoot a /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Copiar el código del proyecto
COPY . /var/www/html/

# 5. Permisos
RUN chown -R www-data:www-data /var/www/html