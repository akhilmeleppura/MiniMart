#!/bin/bash
set -e

# Run migrations automatically
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force
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


