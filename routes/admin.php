<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StaticBlockController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Route::prefix("admin")->group(function () {

    // Guest Routes (Login)
    Route::middleware("guest:admin")->group(function () {
        Route::get('/login', [AdminLoginController::class, 'create'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'store'])->name('admin.authenticate');
    });

    // Authenticated Routes
    Route::middleware("auth:admin")->group(function () {

        // Dashboard & Logout
        Route::get('/dashboard', [DashboardController::class, "index"])->name("dashboard.index");
        Route::post("logout", [AdminLoginController::class, "destroy"])->name("admin.logout");

        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories')->can('manage_categories');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create')->can('manage_categories');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store')->can('manage_categories');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit')->can('manage_categories');
        Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update')->can('manage_categories');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy')->can('manage_categories');
        Route::get('/categories/trash', [CategoryController::class, 'trash'])->name('admin.categories.trash')->can('manage_categories');
        Route::post('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('admin.categories.restore')->can('manage_categories');
        Route::delete('/categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('admin.categories.force-delete')->can('manage_categories');

        // Products
        Route::get('/products', [ProductController::class, 'index'])->name('admin.product.index')->can('manage_products');
        Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create')->can('manage_products');
        Route::post('/product', [ProductController::class, 'store'])->name('admin.product.store')->can('manage_products');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit')->can('manage_products');
        Route::patch('/products/{product}', [ProductController::class, 'update'])->name('admin.product.update')->can('manage_products');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy')->can('manage_products');
        Route::get('/products/trash', [ProductController::class, 'trash'])->name('admin.product.trash')->can('manage_products');
        Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('admin.product.restore')->can('manage_products');
        Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('admin.product.force-delete')->can('manage_products');

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index')->can('manage_orders');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show')->can('manage_orders');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update.status')->can('manage_orders');

        // Customers
        Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers')->can('manage_customers');
        Route::get('/customer/create', [CustomerController::class, 'create'])->name('admin.customers.create')->can('manage_customers');
        Route::post('/customer', [CustomerController::class, 'store'])->name('admin.customers.store')->can('manage_customers');
        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit')->can('manage_customers');
        Route::patch('/customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update')->can('manage_customers');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy')->can('manage_customers');

        // Admins Management
        Route::get('/admins', [AdminController::class, 'index'])->name('admin.admins.index')->can('manage_admins');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.admins.create')->can('manage_admins');
        Route::post('/admins', [AdminController::class, 'store'])->name('admin.admins.store')->can('manage_admins');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admin.admins.edit')->can('manage_admins');
        Route::patch('/admins/{admin}', [AdminController::class, 'update'])->name('admin.admins.update')->can('manage_admins');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admin.admins.destroy')->can('manage_admins');

        // Static Blocks
        Route::get('/static-blocks', [StaticBlockController::class, 'index'])->name('admin.static-blocks.index')->can('manage_static_blocks');
        Route::get('/static-blocks/create', [StaticBlockController::class, 'create'])->name('admin.static-blocks.create')->can('manage_static_blocks');
        Route::post('/static-blocks', [StaticBlockController::class, 'store'])->name('admin.static-blocks.store')->can('manage_static_blocks');
        Route::get('/static-blocks/{staticBlock}/edit', [StaticBlockController::class, 'edit'])->name('admin.static-blocks.edit')->can('manage_static_blocks');
        Route::patch('/static-blocks/{staticBlock}', [StaticBlockController::class, 'update'])->name('admin.static-blocks.update')->can('manage_static_blocks');
        Route::delete('/static-blocks/{staticBlock}', [StaticBlockController::class, 'destroy'])->name('admin.static-blocks.destroy')->can('manage_static_blocks');

        // Static Pages
        Route::get('/static-pages', [StaticPageController::class, 'index'])->name('admin.static-pages.index')->can('manage_static_pages');
        Route::get('/static-pages/create', [StaticPageController::class, 'create'])->name('admin.static-pages.create')->can('manage_static_pages');
        Route::post('/static-pages', [StaticPageController::class, 'store'])->name('admin.static-pages.store')->can('manage_static_pages');
        Route::get('/static-pages/{staticPage}/edit', [StaticPageController::class, 'edit'])->name('admin.static-pages.edit')->can('manage_static_pages');
        Route::patch('/static-pages/{staticPage}', [StaticPageController::class, 'update'])->name('admin.static-pages.update')->can('manage_static_pages');
        Route::delete('/static-pages/{staticPage}', [StaticPageController::class, 'destroy'])->name('admin.static-pages.destroy')->can('manage_static_pages');

        // Roles Management
        Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index')->can('manage_roles');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('admin.roles.create')->can('manage_roles');
        Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store')->can('manage_roles');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit')->can('manage_roles');
        Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update')->can('manage_roles');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy')->can('manage_roles');

        // Slug Generator
        Route::get('/generate-slug', function (Request $request) {
            return response()->json(['slug' => Str::slug($request->name)]);
        })->name('admin.generate-slug');
    });
});
