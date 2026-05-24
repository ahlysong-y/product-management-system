FROM php:8.3-apache

# ១. ដំឡើងតែ Extensions ដែល Laravel ត្រូវការចាំបាច់បំផុត
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ២. ដំឡើង Node.js ជំនាន់ទី 20 ពីប្រភពផ្លូវការ
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# ៣. បើក Apache rewrite mode
RUN a2enmod rewrite

# ៤. កំណត់ Apache Document Root ឱ្យរត់ចូលទៅ Folder 'public' ផ្ទាល់
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# ៥. កំណត់ Working Directory
WORKDIR /var/www/html

# ៦. Copy កូដគម្រោងទាំងអស់
COPY . .

# ៧. បន្ថែម៖ ដំឡើង Node Packages និង Build ឯកសារ Vite (ដោះស្រាយ Error 500)
RUN npm install && npm run build

# ៨. កំណត់សិទ្ធិ (Permissions) ទៅលើ Folder storage, cache និង vendor
RUN chown -R www-data:www-data storage bootstrap/cache vendor \
    && chmod -R 775 storage bootstrap/cache vendor

# ៩. បង្កើត Storage Link របស់ Laravel
RUN php artisan storage:link || true

EXPOSE 80

# ១០. បញ្ជាឱ្យរត់ Migration និងបើក Apache Web Server
CMD php artisan migrate --force && apache2-foreground
