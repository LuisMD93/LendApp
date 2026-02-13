FROM php:8.2-apache

# 1. Cambiar el DocumentRoot de Apache a la carpeta /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 2. Habilitar el módulo de reescritura
RUN a2enmod rewrite

# 3. Copiar los archivos de tu proyecto
COPY . /var/www/html/

# 4. Asegurar permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80