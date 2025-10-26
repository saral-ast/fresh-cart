<div align="center">

# 🛒 Fresh Cart

**A modern e-commerce platform for grocery and retail businesses**

<img src="public/images/freshcart-logo.svg" alt="Fresh Cart Logo" width="250">

[![Laravel](https://img.shields.io/badge/Laravel-v12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-v8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-Latest-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

</div>

## 📋 Overview

Fresh Cart is a comprehensive e-commerce solution built with Laravel, designed specifically for grocery and retail businesses. The platform combines powerful admin capabilities with an intuitive shopping experience, enabling businesses to manage their online presence efficiently while providing customers with a seamless shopping journey.

<div align="center">
  <img src="public/images/grocery-banner.png" alt="Fresh Cart Banner" width="800">
</div>

## ✨ Features

### 🛍️ Customer Experience

- **User-friendly Authentication** - Simple registration and login process
- **Intuitive Product Discovery** - Advanced search and category filtering
- **Seamless Shopping** - Responsive cart functionality and streamlined checkout
- **Order Management** - Real-time tracking and history
- **Profile Customization** - Easy management of personal information and preferences

### 🔧 Admin Dashboard

- **Comprehensive Analytics** - Real-time sales data and performance metrics
- **Complete Product Control** - Full CRUD operations with image management
- **Category Organization** - Hierarchical category structure management
- **Order Processing** - Status updates and customer communication
- **Customer Management** - User data and purchase history
- **Role-based Access** - Customizable permissions system
- **Content Management** - Static blocks and pages for marketing content

## 🚀 Technology Stack

- **Backend Framework**: Laravel 12.0
- **PHP Version**: 8.2+
- **Database Options**: MySQL/MariaDB/SQLite
- **Frontend**: TailwindCSS 4.0, Vite
- **Search Engine**: Laravel Scout with MeiliSearch
- **JavaScript Libraries**: SweetAlert2

## 📦 Requirements

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL/MariaDB or SQLite

## 🔧 Installation

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

```env
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

## 🚀 Running the Application

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

## 👥 User Accounts

After running the seeders, the following accounts will be available:

### Admin
- **Email**: admin@freshcart.com
- **Password**: password

### Customer
- **Email**: user@example.com
- **Password**: password

## 📁 Project Structure

```
fresh-cart/
├── app/                  # Core application code
│   ├── Http/Controllers/ # Request handlers
│   ├── Models/           # Database models
│   └── Services/         # Business logic
├── database/             # Migrations and seeders
├── resources/            # Frontend assets and views
└── routes/               # Application routes
    ├── admin.php         # Admin panel routes
    └── user.php          # Customer-facing routes
```

## 📝 License

The Fresh Cart application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

<div align="center">

**Built with ❤️ for modern e-commerce**

</div>
