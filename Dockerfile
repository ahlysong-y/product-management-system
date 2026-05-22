FROM php:8.2-apache

# ១. ដំឡើង Dependencies របស់ Linux (រួមទាំង unzip និង p7zip-full ដើម្បីកុំឱ្យគាំង Composer ដូចមុន)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    p7zip-full \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql zip

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

# ៧. Copy តែឯកសារ Composer config ទៅដំឡើងជាមុនសិន (ដើម្បីកុំឱ្យជល់សិទ្ធិ Permissions)
COPY composer.json composer.lock ./

# ៨. រត់ Composer Install (បន្ថែម --prefer-dist ដើម្បីឱ្យវារត់លឿន និងទាញយកកញ្ចប់ហ្ស៊ីបមកពន្លាដោយសុវត្ថិភាព)
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --optimize-autoloader --ignore-platform-reqs --prefer-dist

# ៩. Copy កូដគម្រោងទាំងអស់ដែលនៅសល់ ចូលទៅក្នុង Container
COPY . .

# ១០. ដំឡើង Node packages និងធ្វើការ Build ឯកសារ Frontend (CSS/JS)
RUN npm install \
    && npm run build

# ១១. កំណត់សិទ្ធិ (Permissions) ទៅលើ Folder storage និង cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ១២. បង្កើត Storage Link របស់ Laravel
RUN php artisan storage:link || true

EXPOSE 80

# ១៣. បញ្ជាឱ្យរត់ Migration និងបើក Apache Web Server
CMD php artisan migrate --force && apache2-foreground
