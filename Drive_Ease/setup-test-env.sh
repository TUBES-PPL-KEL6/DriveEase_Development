#!/bin/bash

# Create test database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS drive_ease_test;"

# Copy .env to .env.testing
cp .env .env.testing

# Update .env.testing with test database
sed -i 's/DB_DATABASE=.*/DB_DATABASE=drive_ease_test/' .env.testing

# Clear config cache
php artisan config:clear
php artisan config:cache

# Run migrations and seeders
php artisan migrate:fresh --env=testing
php artisan db:seed --class=TestDataSeeder --env=testing

echo "Testing environment setup complete!" 