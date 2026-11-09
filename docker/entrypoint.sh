#!/bin/bash

# Ensure storage directories and symlink exist
mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

php artisan storage:link || true

# Run migrations automatically
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || true
    php artisan migrate --path=Modules/Customer/database/migrations --force || true
    php artisan migrate --path=Modules/Category/database/migrations --force || true
    php artisan migrate --path=Modules/Products/database/migrations --force || true
    php artisan migrate --path=Modules/OrderManagement/database/migrations --force || true
    php artisan migrate --path=Modules/CMS/database/migrations --force || true
    php artisan migrate --path=Modules/StoreManagement/database/migrations --force || true
    php artisan migrate --path=Modules/TaxManagement/database/migrations --force || true
    php artisan migrate --path=Modules/ShippingMethode/database/migrations --force || true
    php artisan migrate --path=Modules/PaymentManagement/database/migrations --force || true
    php artisan migrate --path=Modules/PaymentMethod/database/migrations --force || true
    php artisan migrate --path=Modules/PriceRuleManagement/database/migrations --force || true
    php artisan migrate --path=Modules/ProductAttributes/database/migrations --force || true
    php artisan migrate --path=Modules/Cart/database/migrations --force || true
    php artisan migrate --path=Modules/UserPermission/database/migrations --force || true
    php artisan migrate --path=Modules/WebConfigurationManagement/database/migrations --force || true
    php artisan migrate --path=Modules/URLRewrite/database/migrations --force || true
    php artisan migrate --path=Modules/NewsLetter/database/migrations --force || true
    php artisan migrate --path=Modules/Dashboard/database/migrations --force || true
    php artisan migrate --path=Modules/Base/database/migrations --force || true
    php artisan migrate --path=Modules/Api/database/migrations --force || true
fi

# Run seeders automatically for showcase demos
if [ "$RUN_SEEDERS" = "true" ]; then
    echo "Seeding showcase demo data..."
    php artisan db:seed --force || true
fi

# Clear all caches so dynamic modules and hint paths are clean
php artisan optimize:clear || true

# Start Apache in foreground
echo "Starting Apache..."
exec apache2-foreground
