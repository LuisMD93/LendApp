#!/bin/bash

# Mostrar el puerto para debug
echo "Puerto asignado por Render: $PORT"

# Cambiar Apache para escuchar en el puerto dinámico de Render
sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Iniciar Apache en primer plano
apache2-foreground