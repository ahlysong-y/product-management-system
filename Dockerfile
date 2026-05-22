FROM php:8.2-apache

# ១. ដំឡើង Dependencies របស់ Linux និង PHP Extensions (PostgreSQL, Zip)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql zip

# ២. ដំឡើង Node.js ជំនាន់ទី 20 ពីប្រភពផ្លូវការ (ដើម្បីកុំឱ្យមាន Error ដូចមុន)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# ៣. បើក Apache rewrite mode
RUN a2enmod rewrite

# ៤. កំណត់ Apache Document Root ឱ្យរត់ចូលទៅ Folder 'public' ផ្ទាល់ (ដោះស្រាយបញ្ហាខូចប្លង់ CSS/JS)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# ៥. ទាញយក Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ៦. កំណត់ Working Directory
WORKDIR /var/www/html

# ៧. Copy ឯកសារ package.json រួចដំឡើង និង Build CSS/JS (Vite)
COPY package*.json ./
RUN npm install
RUN npm run build

# ៨. Copy កូដគម្រោង Laravel ទាំងមូលចូលទៅក្នុង Container
COPY . .

# ៩. ដំឡើង Laravel dependencies តាមរយៈ Composer
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --optimize-autoloader --ignore-platform-reqs

# ១០. កំណត់សិទ្ធិ (Permissions) ទៅលើ Folder storage និង cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ១១. បង្កើត Storage Link របស់ Laravel
RUN php artisan storage:link || true

EXPOSE 80

# ១២. បញ្ជាឱ្យរត់ Migration រាល់ពេលបើក Container រួចបើក Apache Web Server ឱ្យដំណើរការផ្សាយផ្ទាល់
CMD php artisan migrate --force && apache2-foreground
