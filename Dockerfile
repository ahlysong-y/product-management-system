FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql zip

# Enable Apache rewrite
RUN a2enmod rewrite

# Set Apache Document Root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set Working Directory
WORKDIR /var/www/html

# Copy Project
COPY . .

# Install Laravel dependencies
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --optimize-autoloader --ignore-platform-reqs

# Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

# Generate storage link
RUN php artisan storage:link || true

EXPOSE 80

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=80
# ១. ដំឡើង Node.js និង NPM នៅក្នុង Container (ប្រសិនបើមិនទាន់មាន)
USER root
RUN apt-get update && apt-get install -y nodejs npm

# ២. ទាញយក package និងធ្វើការ Build ឯកសារ Frontend (CSS/JS) សម្រាប់ Production
COPY package*.json ./
RUN npm install
RUN npm run build


