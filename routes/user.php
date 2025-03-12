<?php
use App\Http\Controllers\Auth\SignInController;
use Illuminate\Support\Facades\Route;



Route::middleware("guest:user")->group(function() {
    Route::get("register", [SignInController::class, 'create'])->name("user.signin");
    Route::post("register", [SignInController::class, 'store']);
    // Route::post("login", [LoginController::class, "authenticate"])->name("customer.authenticate");
});

// Route::middleware("auth:customer")->group(function() {
//     Route::get("logout", [LoginController::class, "logout"])->name("customer.logout");
//     Route::get("/", [HomepageController::class, "index"])->name("homepage");
// });
Route::get('/', function () {
    return view('welcome');
}); 
// Route::get('/register', function () {
//     return view('auth.register');
// });
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/categories', function () {
    return view('categories');
});
Route::get('/contact', function () {
    return view('contact');
});
Route::get('/products', function () {
    return view('products');
});
Route::get('/product', function () {
    $product = [
        'name' => 'Apple iMac 24" All-In-One Computer, Apple M1, 8GB RAM, 256GB SSD, Mac OS, Pink',
        'price' => 1249.99,
        'rating' => 5.0,
        'reviews' => 345,
        'description' => "Studio quality three mic array for crystal clear calls and voice recordings. Six-speaker sound system for a remarkably robust and high-quality audio experience. Up to 256GB of ultrafast SSD storage.",
        'features' => "Two Thunderbolt USB 4 ports and up to two USB 3 ports. Ultrafast Wi-Fi 6 and Bluetooth 5.0 wireless. Color matched Magic Mouse with Magic Keyboard or Magic Keyboard with Touch ID.",
        'image' => [
            'light' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg',
            'dark' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg'
        ]
    ];
    return view('product', ['product' => $product]);
});
Route::get('/cart', function () {
    return view('cart');
});