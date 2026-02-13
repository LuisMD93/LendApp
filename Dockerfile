FROM php:8.2-apache

# Cambiar el DocumentRoot a /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Habilitar mod_rewrite para rutas de PHP
RUN a2enmod rewrite

# Copiar el código
COPY . /var/www/html/

# Dar permisos a la carpeta
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80