#!/bin/bash
set -e

echo "Building frontend assets..."
npm run build

# Check if this is the first run (fresh environment)
if [ ! -f ".first_run" ]; then
    echo "Fresh start detected - running migrations and seeding..."
    php artisan migrate:fresh --seed
    touch .first_run
    echo "Database initialized with migrations and seeds!"
else
    echo "Development restart detected - skipping migrations and seeds..."
fi

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=5000
