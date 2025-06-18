#!/bin/bash

# Laravel Task Management Application - Deployment Script
# This script automates the deployment process for the Laravel Task Management Application

echo "🚀 Laravel Task Management Application - Deployment Script"
echo "=========================================================="

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 8.1 or higher."
    exit 1
fi

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
if [[ $(echo "$PHP_VERSION < 8.1" | bc -l) -eq 1 ]]; then
    echo "❌ PHP version $PHP_VERSION is not supported. Please install PHP 8.1 or higher."
    exit 1
fi

echo "✅ PHP version $PHP_VERSION detected"

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer first."
    echo "   Visit: https://getcomposer.org/download/"
    exit 1
fi

echo "✅ Composer detected"

# Install dependencies
echo "📦 Installing PHP dependencies..."
composer install --optimize-autoloader

# Check if .env file exists
if [ ! -f .env ]; then
    echo "📝 Creating environment file..."
    cp .env.example .env
    
    # Generate application key
    echo "🔑 Generating application key..."
    php artisan key:generate
    
    echo "⚙️  Configuring database..."
    # Set up SQLite database configuration
    sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
    sed -i 's|DB_DATABASE=laravel|DB_DATABASE='$(pwd)'/database/database.sqlite|' .env
    
    # Comment out MySQL-specific settings
    sed -i 's/^DB_HOST=/#DB_HOST=/' .env
    sed -i 's/^DB_PORT=/#DB_PORT=/' .env
    sed -i 's/^DB_USERNAME=/#DB_USERNAME=/' .env
    sed -i 's/^DB_PASSWORD=/#DB_PASSWORD=/' .env
else
    echo "✅ Environment file already exists"
fi

# Create SQLite database file if it doesn't exist
if [ ! -f database/database.sqlite ]; then
    echo "🗄️  Creating SQLite database..."
    touch database/database.sqlite
else
    echo "✅ Database file already exists"
fi

# Run migrations
echo "🔄 Running database migrations..."
php artisan migrate --force

# Clear and cache configuration
echo "🧹 Optimizing application..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "🔒 Setting file permissions..."
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo ""
echo "🎉 Deployment completed successfully!"
echo ""
echo "To start the application:"
echo "  php artisan serve"
echo ""
echo "Then visit: http://localhost:8000"
echo ""
echo "For production deployment, point your web server to the 'public' directory."
echo ""

