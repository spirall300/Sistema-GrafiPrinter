# Usa imagen base de PHP con Apache
FROM php:8.3-apache

# Instala dependencias del sistema (incluye Node.js para Vite)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    unzip \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql zip gd intl

# Habilita mod_rewrite para Laravel
RUN a2enmod rewrite

# Configura Apache para Laravel
RUN echo '<VirtualHost *:80>\n\tServerAdmin webmaster@localhost\n\tDocumentRoot /var/www/html/public\n\t<Directory /var/www/html/public>\n\t\tAllowOverride All\n\t\tRequire all granted\n\t</Directory>\n</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Copia el código de la app
COPY . /var/www/html

# Instala Composer y dependencias
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Crea enlace simbólico para storage
RUN php artisan storage:link

# Cambia permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Construye assets (Vite/Tailwind)
RUN npm install && npm run build

# Expone puerto 80
EXPOSE 80

# Comando para ejecutar Apache
CMD ["apache2-foreground"]
