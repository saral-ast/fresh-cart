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

Route::prefix("admin")->group(function() {

    // Guest Routes (Login)
    Route::middleware("guest:admin")->group(function() {
        Route::get('/login', [AdminLoginController::class, 'create'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'store'])->name('admin.authenticate');
    });

    // Authenticated Routes
    Route::middleware("auth:admin")->group(function() {

        // Dashboard & Logout
        Route::get('/dashboard', [DashboardController::class, "index"])->name("dashboard.index");
        Route::post("logout", [AdminLoginController::class, "destroy"])->name("admin.logout");

        // Categories (with soft delete actions)
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories')->can('manage_categories');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create')->can('manage_categories');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store')->can('manage_categories');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit')->can('manage_categories');
        Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update')->can('manage_categories');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy')->can('manage_categories');
        Route::get('/categories/trash', [CategoryController::class, 'trash'])->name('admin.categories.trash')->can('manage_categories');
        Route::post('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('admin.categories.restore')->can('manage_categories');
        Route::delete('/categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('admin.categories.force-delete')->can('manage_categories');

        // Products (with soft delete actions)
        Route::get('/products', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::patch('/products/{product}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
        Route::get('/products/trash', [ProductController::class, 'trash'])->name('admin.product.trash');
        Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('admin.product.restore');
        Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('admin.product.force-delete');

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update.status');

        // Customers
        Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers');
        Route::get('/customer/create', [CustomerController::class, 'create'])->name('admin.customers.create');
        Route::post('/customer', [CustomerController::class, 'store'])->name('admin.customers.store');
        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit');
        Route::patch('/customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');

        // Admins Management
        Route::get('/admins', [AdminController::class, 'index'])->name('admin.admins.index');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.admins.create');
        Route::post('/admins', [AdminController::class, 'store'])->name('admin.admins.store');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admin.admins.edit');
        Route::patch('/admins/{admin}', [AdminController::class, 'update'])->name('admin.admins.update');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admin.admins.destroy');

        // Static Blocks
        Route::get('/static-blocks', [StaticBlockController::class, 'index'])->name('admin.static-blocks.index');
        Route::get('/static-blocks/create', [StaticBlockController::class, 'create'])->name('admin.static-blocks.create');
        Route::post('/static-blocks', [StaticBlockController::class, 'store'])->name('admin.static-blocks.store');
        Route::get('/static-blocks/{staticBlock}/edit', [StaticBlockController::class, 'edit'])->name('admin.static-blocks.edit');
        Route::patch('/static-blocks/{staticBlock}', [StaticBlockController::class, 'update'])->name('admin.static-blocks.update');
        Route::delete('/static-blocks/{staticBlock}', [StaticBlockController::class, 'destroy'])->name('admin.static-blocks.destroy');

        // Static Pages
        Route::get('/static-pages', [StaticPageController::class, 'index'])->name('admin.static-pages.index');
        Route::get('/static-pages/create', [StaticPageController::class, 'create'])->name('admin.static-pages.create');
        Route::post('/static-pages', [StaticPageController::class, 'store'])->name('admin.static-pages.store');
        Route::get('/static-pages/{staticPage}/edit', [StaticPageController::class, 'edit'])->name('admin.static-pages.edit');
        Route::patch('/static-pages/{staticPage}', [StaticPageController::class, 'update'])->name('admin.static-pages.update');
        Route::delete('/static-pages/{staticPage}', [StaticPageController::class, 'destroy'])->name('admin.static-pages.destroy');

        // Roles Management
        Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
        Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
        
        // Permissions Management
        Route::get('/permissions', [PermissionController::class, 'index'])->name('admin.permissions.index');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('admin.permissions.create');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('admin.permissions.store');
        Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
        Route::patch('/permissions/{permission}', [PermissionController::class, 'update'])->name('admin.permissions.update');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');

        // Slug Generator (Only for authenticated admins)
        Route::get('/generate-slug', function (Request $request) {
            return response()->json(['slug' => Str::slug($request->name)]);
        })->name('admin.generate-slug');
    });

});
