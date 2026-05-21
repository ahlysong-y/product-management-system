FROM php:8.2-apache

# ដំឡើង extensions ចាំបាច់សម្រាប់ PostgreSQL និង Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql zip

# បើក Apache rewrite module
RUN a2enmod rewrite

# កំណត់ Document Root ទៅកាន់ public folder របស់ Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# ដំឡើង Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ចម្លងកូដគម្រោងចូលទៅក្នុង Server
WORKDIR /var/www/html
COPY . .

# ដំឡើង dependencies របស់ Laravel
RUN composer install --no-dev --optimize-autoloader

# កំណត់សិទ្ធិ (Permission) ទៅលើ folder របស់ Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
