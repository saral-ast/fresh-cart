# Fresh Cart E-commerce Platform

<p align="center">
  <img src="public/images/freshcart-logo.svg" alt="Fresh Cart Logo" width="200">
</p>

## Overview

Fresh Cart is a modern e-commerce platform built with Laravel, designed for grocery and retail businesses. The application features a comprehensive admin panel for managing products, categories, and orders, along with a user-friendly shopping experience for customers.

## Features

### Customer Features
- User registration and authentication
- Product browsing and searching
- Category filtering
- Shopping cart functionality
- Checkout process
- Order tracking
- User profile management

### Admin Features
- Dashboard with sales analytics
- Product management (CRUD operations)
- Category management
- Order management
- Customer management
- Role and permission management
- Static blocks and pages management

## Technology Stack

- **PHP**: ^8.2
- **Laravel**: ^12.0
- **Database**: MySQL/MariaDB/SQLite
- **Frontend**: TailwindCSS 4.0, Vite
- **Search**: Laravel Scout with MeiliSearch
- **JavaScript Libraries**: SweetAlert2

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL/MariaDB or SQLite

## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd fresh-cart
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install JavaScript dependencies

```bash
npm install
```

### 4. Set up environment variables

```bash
cp .env.example .env
php artisan key:generate
```

Edit the `.env` file to configure your database connection:

```
DB_CONNECTION=mysql  # or sqlite, pgsql, sqlsrv
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fresh_cart
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run database migrations and seeders

```bash
php artisan migrate --seed
```

### 6. Build frontend assets

```bash
npm run build
```

## Running the Application

### Development Mode

Run the application with hot-reloading for development:

```bash
composer dev
```

This command will concurrently start:
- Laravel development server
- Queue worker
- Vite development server

Alternatively, you can run each service separately:

```bash
# Laravel server
php artisan serve

# Queue worker
php artisan queue:work

# Vite development server
npm run dev
```

### Production Mode

For production deployment:

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## User Accounts

After running the seeders, the following accounts will be available:

### Admin
- Email: admin@example.com
- Password: password

### Customer
- Email: user@example.com
- Password: password

## Project Structure

- `app/` - Contains the core code of the application
  - `Http/Controllers/` - Request handlers
  - `Models/` - Database models
  - `Services/` - Business logic
- `database/` - Database migrations and seeders
- `resources/` - Frontend assets and views
- `routes/` - Application routes
  - `admin.php` - Admin panel routes
  - `user.php` - Customer-facing routes

## License

The Fresh Cart application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
