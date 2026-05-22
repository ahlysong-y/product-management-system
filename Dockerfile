FROM php:8.2-apache

# ១. ដំឡើង Dependencies របស់ Linux
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
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

# ៥. ទាញយក Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ៦. កំណត់ Working Directory
WORKDIR /var/www/html

# ៧. Copy កូដគម្រោងទាំងអស់ចូលទៅក្នុង Container មុនគេ
COPY . .

# ៨. ដំឡើង Laravel dependencies តាមរយៈ Composer (បន្ថែមការការពារកុំឱ្យគាំងទាញយក)
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --optimize-autoloader --ignore-platform-reqs --prefer-dist --no-cache

# ៩. ដំឡើង Node packages និងធ្វើការ Build ឯកសារ Frontend (CSS/JS)
RUN npm install \
    && npm run build

# ១០. កំណត់សិទ្ធិ (Permissions) ទៅលើ Folder storage និង cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ១១. បង្កើត Storage Link របស់ Laravel
RUN php artisan storage:link || true

EXPOSE 80

# ១២. បញ្ជាឱ្យរត់ Migration និងបើក Apache Web Server
CMD php artisan migrate --force && apache2-foreground
