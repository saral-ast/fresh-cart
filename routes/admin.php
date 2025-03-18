<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
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
        Route::get('/dashboard', function () {
            $orders = collect([
                (object) [
                    'order_number' => '#FC0005',
                    'product_name' => "Haldiram's Sev Bhujia",
                    'order_date' => '28 March 2023',
                    'price' => 18.00,
                    'status' => 'Shipped',
                ],
                (object) [
                    'order_number' => '#FC0004',
                    'product_name' => 'NutriChoice Digestive',
                    'order_date' => '24 March 2023',
                    'price' => 24.00,
                    'status' => 'Pending',
                ],
                (object) [
                    'order_number' => '#FC0003',
                    'product_name' => 'Onion Flavour Potato',
                    'order_date' => '8 Feb 2023',
                    'price' => 9.00,
                    'status' => 'Cancel',
                ],
                (object) [
                    'order_number' => '#FC0002',
                    'product_name' => 'Blueberry Greek Yogurt',
                    'order_date' => '20 Jan 2023',
                    'price' => 12.00,
                    'status' => 'Pending',
                ],
                (object) [
                    'order_number' => '#FC0001',
                    'product_name' => 'Slurrp Millet Chocolate',
                    'order_date' => '14 Jan 2023',
                    'price' => 8.00,
                    'status' => 'Processing',
                ],
            ]);
            
            return view('dashboard.index', compact('orders'));
            
        })->name('dashboard.index');
        
        // Route::get("/", [DashboardController::class, "index"])->name("admin.dashboard");
        Route::post("logout", [AdminLoginController::class, "destroy"])->name("admin.logout");
        Route::get('/categories',[CategoryController::class,'index'])->name('admin.categories');
        Route::get('/categories/create',[CategoryController::class,'create'])->name('admin.categories.create');
        Route::post('/categories',[CategoryController::class,'store'])->name('admin.categories.store');
        Route::get('/categories/{category}/edit',[CategoryController::class,'edit'])->name('admin.categories.edit');
        Route::patch('/categories/{category}',[CategoryController::class,'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}',[CategoryController::class,'destroy'])->name('admin.categories.destroy');

        //product
        Route::get('/products',[ProductController::class,'index'])->name('admin.product.index');
        Route::get('/product/create', [ProductController::class,'create'])->name('admin.product.create');
        Route::post('/product', [ProductController::class,'store'])->name('admin.product.store');
        Route::get('/products/{product}/edit',[ProductController::class,'edit'])->name('admin.product.edit');
        Route::patch('/products/{product}',[ProductController::class,'update'])->name('admin.product.update');  
        Route::delete('/products/{product}',[ProductController::class,'destroy'])->name('admin.product.destroy');

        Route::get('/customers',[CustomerController::class,'index'])->name('admin.customers');
        Route::get('/customer/create',[CustomerController::class,'create'])->name('admin.customers.create');
        Route::post('/customer',[CustomerController::class,'store'])->name('admin.customers.store');
        Route::get('/customers/{customer}/edit',[CustomerController::class,'edit'])->name('admin.customers.edit');
        Route::patch('/customers/{customer}',[CustomerController::class,'update'])->name('admin.customers.update');
        Route::delete('/customers/{customer}',[CustomerController::class,'destroy'])->name('admin.customers.destroy');
    });

});
// Route::get('/admin/login', function () {
//     return view('auth.admin-login');
// });




Route::get('/dashboard/orders', function () { 
    $orders = collect([
        (object) [
            'image' => 'https://via.placeholder.com/40', // Replace with actual image URL
            'order_number' => 'FC#1004',
            'customer' => 'Ezekiel Rogerson',
            'order_date' => '09 March 2023 (6:23 pm)',
            'payment' => 'Stripe',
            'status' => 'Success',
            'amount' => '$23.11',
        ],
        (object) [
            'image' => 'https://via.placeholder.com/40',
            'order_number' => 'FC#1003',
            'customer' => 'Maria Roux',
            'order_date' => '18 Feb 2022 (12:20 pm)',
            'payment' => 'COD',
            'status' => 'Success',
            'amount' => '$2.00',
        ],
        (object) [
            'image' => 'https://via.placeholder.com/40',
            'order_number' => 'FC#1002',
            'customer' => 'Robert Donald',
            'order_date' => '12 Feb 2022 (4:56 pm)',
            'payment' => 'Paypal',
            'status' => 'Cancel',
            'amount' => '$56.00',
        ],
        (object) [
            'image' => 'https://via.placeholder.com/40',
            'order_number' => 'FC#1001',
            'customer' => 'Diann Watson',
            'order_date' => '22 Jan 2023 (1:20 pm)',
            'payment' => 'Paypal',
            'status' => 'Success',
            'amount' => '$23.00',
        ],
    ]);

    return view('dashboard.orders', compact('orders'));
});

Route::get('/admin/generate-slug', function (Request $request) {
    $slug = Str::slug($request->name);
    return response()->json(['slug' => $slug]);
});