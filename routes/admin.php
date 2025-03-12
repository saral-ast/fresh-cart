<?php

use Illuminate\Support\Facades\Route;

// Route::prefix("admin")->group(function() {

//     Route::middleware("guest:admin")->group(function() {
//         Route::get("login", [AdminLoginController::class, "index"])->name("admin.login");
//         Route::post("login", [AdminLoginController::class, "authenticate"])->name("admin.authenticate");
//     });

//     Route::middleware("auth:admin")->group(function() {
//         Route::get("/", [DashboardController::class, "index"])->name("admin.dashboard");
//         Route::get("logout", [AdminLoginController::class, "logout"])->name("admin.logout");
//     });

// });
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
    
});

Route::get('/dashboard/product', function () {
    $products = collect([
        (object) [
            'product_id' => '#P0001',
            'name' => "Haldiram's Sev Bhujia",
            'category' => "Snack & Munchies",
            'price' => 18.00,
            'status' => 'Active',
            'added_on' => '24 Nov 2022',
            'image' => Vite::asset('resources/images/products/product-img-1.jpg'),   
        ],
            ]);
    
    return view('dashboard.product', compact('products'));
});

Route::get('/dashboard/categories', function () { 
    $categories = collect([
        (object) [
            'icon' => 'https://cdn-icons-png.flaticon.com/128/2921/2921822.png',
            'name' => 'Organic Vegetables',
            'type' => 'Grocery',
            'status' => 'Published'
        ],
        (object) [
            'icon' => 'https://cdn-icons-png.flaticon.com/128/2921/2921826.png',
            'name' => 'Dairy Products',
            'type' => 'Dairy',
            'status' => 'Published'
        ],
        (object) [
            'icon' => 'https://cdn-icons-png.flaticon.com/128/2921/2921833.png',
            'name' => 'Frozen Foods',
            'type' => 'Frozen',
            'status' => 'Unpublished'
        ]
    ]);

    return view('dashboard.categories', compact('categories'));
});
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
Route::get('/dashboard/customers', function () {
    $customers = collect([
        (object) [
            'name' => 'Bonnie Howe',
            'email' => 'bonniehowe@gmail.com',
            'purchase_date' => '2023-05-17 15:18:00',
            'phone' => null,
            'spent' => 49.00,
            'avatar' => 'https://i.pravatar.cc/40?u=bonniehowe@gmail.com'
        ],
        (object) [
            'name' => 'Judy Nelson',
            'email' => 'judynelson@gmail.com',
            'purchase_date' => '2023-04-27 14:47:00',
            'phone' => '435-239-6436',
            'spent' => 490.00,
            'avatar' => 'https://i.pravatar.cc/40?u=judynelson@gmail.com'
        ],
        (object) [
            'name' => 'John Mattox',
            'email' => 'johnmattox@gmail.com',
            'purchase_date' => '2023-04-27 14:47:00',
            'phone' => '347-424-9526',
            'spent' => 29.00,
            'avatar' => 'https://i.pravatar.cc/40?u=johnmattox@gmail.com'
        ],
        (object) [
            'name' => 'Wayne Rossman',
            'email' => 'waynerossman@gmail.com',
            'purchase_date' => '2023-04-27 14:47:00',
            'phone' => null,
            'spent' => 39.00,
            'avatar' => 'https://i.pravatar.cc/40?u=waynerossman@gmail.com'
        ],
    ]);

    return view('dashboard.customers', compact('customers'));

});