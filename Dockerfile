FROM php:8.2-apache

# 1. Instalar dependencias del sistema y extensiones de PHP para MySQL
RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    && docker-php-ext-install pdo pdo_mysql

# 2. Habilitar mod_rewrite de Apache (Esto ya lo tenías, mantenlo)
RUN a2enmod rewrite

# 3. Configurar el DocumentRoot a /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Copiar el código del proyecto
COPY . /var/www/html/

# 5. Permisos
RUN chown -R www-data:www-data /var/www/html