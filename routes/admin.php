<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StaticBlockController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



Route::prefix("admin")->group(function() {

    Route::middleware("guest:admin")->group(function() {
        Route::get('/login',[AdminLoginController::class,'create'])->name('admin.login');
        Route::post('/login',[AdminLoginController::class,'store'])->name('admin.authenticate');
        // Route::get("login", [AdminLoginController::class, "index"])->name("admin.login");
        // Route::post("login", [AdminLoginController::class, "authenticate"])->name("admin.authenticate");
    });

    Route::middleware("auth:admin")->group(function() {
        Route::get('/dashboard', [DashboardController::class, "index"])->name("dashboard.index");
        
        // Route::get("/", [DashboardController::class, "index"])->name("admin.dashboard");
        Route::post("logout", [AdminLoginController::class, "destroy"])->name("admin.logout");
        
        Route::get('/categories',[CategoryController::class,'index'])->name('admin.categories');
        Route::get('/categories/create',[CategoryController::class,'create'])->name('admin.categories.create');
        Route::post('/categories',[CategoryController::class,'store'])->name('admin.categories.store');
        Route::get('/categories/{category}/edit',[CategoryController::class,'edit'])->name('admin.categories.edit');
        Route::patch('/categories/{category}',[CategoryController::class,'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}',[CategoryController::class,'destroy'])->name('admin.categories.destroy');
        Route::get('/categories/trash',[CategoryController::class,'trash'])->name('admin.categories.trash');
        Route::post('/categories/{id}/restore',[CategoryController::class,'restore'])->name('admin.categories.restore');
        Route::delete('/categories/{id}/force-delete',[CategoryController::class,'forceDelete'])->name('admin.categories.force-delete');

        //product
        Route::get('/products',[ProductController::class,'index'])->name('admin.product.index');
        Route::get('/product/create', [ProductController::class,'create'])->name('admin.product.create');
        Route::post('/product', [ProductController::class,'store'])->name('admin.product.store');
        Route::get('/products/{product}/edit',[ProductController::class,'edit'])->name('admin.product.edit');
        Route::patch('/products/{product}',[ProductController::class,'update'])->name('admin.product.update');  
        Route::delete('/products/{product}',[ProductController::class,'destroy'])->name('admin.product.destroy');
        Route::get('/products/trash',[ProductController::class,'trash'])->name('admin.product.trash');
        Route::post('/products/{id}/restore',[ProductController::class,'restore'])->name('admin.product.restore');
        Route::delete('/products/{id}/force-delete',[ProductController::class,'forceDelete'])->name('admin.product.force-delete');

        //orders
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update.status');

        //customers
        Route::get('/customers',[CustomerController::class,'index'])->name('admin.customers');
        Route::get('/customer/create',[CustomerController::class,'create'])->name('admin.customers.create');
        Route::post('/customer',[CustomerController::class,'store'])->name('admin.customers.store');
        Route::get('/customers/{customer}/edit',[CustomerController::class,'edit'])->name('admin.customers.edit');
        Route::patch('/customers/{customer}',[CustomerController::class,'update'])->name('admin.customers.update');
        Route::delete('/customers/{customer}',[CustomerController::class,'destroy'])->name('admin.customers.destroy');
        
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
    });

});
// Route::get('/admin/login', function () {
//     return view('auth.admin-login');
// });






Route::get('/admin/generate-slug', function (Request $request) {
    $slug = Str::slug($request->name);
    return response()->json(['slug' => $slug]);
});