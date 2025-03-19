<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use Illuminate\Support\Facades\Route;



Route::middleware("guest:user")->group(function() {
    Route::get("register", [SignInController::class, 'create'])->name("user.signin");
    Route::post("register", [SignInController::class, 'store']);
    Route::get("login", [LoginController::class, 'create'])->name("user.login");
    Route::post("login", [LoginController::class, "store"]);
    // Route::post("login", [LoginController::class, "authenticate"])->name("customer.authenticate");
});

Route::middleware("auth:user")->group(function() {
    Route::post("logout", [LoginController::class, "destroy"])->name("user.logout");
    Route::get("/cart",[CartController::class, 'show'])->name('cart.show');
    Route::post("cart/{slug}",[CartController::class, "store"])->name('cart.store');
    Route::post('/curi: art/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete("cart/{slug}",[CartController::class, "destroy"])->name('cart.remove');
    // Route::get('/cart', function () {
    //     return view('cart');
    // });
});


Route::get('/', [HomeController::class,'index'] )->name('home'); 
Route::get('/categories',[CategoryController::class,'index']);
Route::get('/categories/{slug}',[CategoryController::class,'show']) ->name('user.category.show');

Route::get('/products', [ProductController::class,'index'])->name('user.product.index');
Route::get('/products/{slug}', [ProductController::class,'show'])->name('user.product.show');
Route::get('/contact', function () {
    return view('contact');
});
// Route::get('/products', function () {
//     return view('products');
// });
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
