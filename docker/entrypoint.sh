#!/bin/bash
set -e

# Run migrations automatically
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force
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

# Ensure storage directories and symlink exist
php artisan storage:link || true

# Cache configurations in production
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Start Apache in foreground
exec apache2-foreground


