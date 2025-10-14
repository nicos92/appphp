# Usa tu imagen base de PHP
FROM php:8.2-apache

# Instala las extensiones mysqli y pdo_mysql
RUN docker-php-ext-install mysqli pdo_mysql

# ¡NUEVA LÍNEA CLAVE! Habilita el módulo mod_rewrite de Apache
RUN a2enmod rewrite

# Establece el directorio de trabajo predeterminado
WORKDIR /var/www/html
