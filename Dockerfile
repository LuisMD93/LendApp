FROM php:8.2-apache

# Habilitar el módulo de reescritura de Apache (útil para rutas amigables)
RUN a2enmod rewrite

# Copiar los archivos de tu proyecto al directorio del servidor
COPY . /var/www/html/

# Asegurar permisos correctos para que Apache pueda leer los archivos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80