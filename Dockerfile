FROM php:8.2-apache

# 1. Cambiamos el DocumentRoot de Apache a la carpeta /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 2. Habilitar el módulo de reescritura de Apache
RUN a2enmod rewrite

# 3. Copiar el código del proyecto
COPY . /var/www/html/

# 4. Ajustar permisos para Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80