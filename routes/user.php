<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderPlacedController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ProfileCOntroller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// use App\Model\Admin\Product;



Route::middleware("guest:user")->group(function() {
    Route::get("register", [SignInController::class, 'create'])->name("user.signin");
    Route::post("register", [SignInController::class, 'store']);
    Route::get("login", [LoginController::class, 'create'])->name("user.login");
    Route::post("login", [LoginController::class, "store"]);
});

Route::middleware("auth:user")->group(function() {
    Route::post("logout", [LoginController::class, "destroy"])->name("user.logout");

    Route::get('/profile',[ProfileCOntroller::class,'index'])->name('user.profile');
    Route::post('/profile',[ProfileCOntroller::class,'update'])->name('user.profile.update');

    Route::get("/cart",[CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post("/cart/{slug}",[CartController::class, "store"])->name('cart.store');
    Route::delete("/cart/{slug}",[CartController::class, "destroy"])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.store');
    Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('order.success');
});


Route::get('/', [HomeController::class,'index'] )->name('home'); 
Route::get('/categories',[CategoryController::class,'index']);
Route::get('/categories/{slug}',[CategoryController::class,'show']) ->name('user.category.show');
Route::get('/api/categories/with-count', [CategoryController::class, 'getWithCount']);

Route::get('/products', [ProductController::class,'index'])->name('user.product.index');
Route::get('/api/products/filter', [ProductController::class, 'filter']);
Route::get('/products/{slug}', [ProductController::class,'show'])->name('user.product.show');
Route::get('/search/products', [ProductController::class,'search'])->name('user.product.search');

// Static Pages
Route::get('/{slug}', [\App\Http\Controllers\User\PageController::class, 'show'])->name('page');

// Route::get('/products', function () {
//     return view('products');
// });
Route::get('/preview', function () {
  
    
    $user = Auth::user();
    // dd($user);
    return view('emails.welcome',[
        'user' => $user]);
});

Route::get('/order/preview', function () {
  
    
    $user = Auth::user();
    $order = Order::where('user_id', $user->id)->latest()->first();
    // dd($user);
    return view('emails.order-placed',[
        'user' => $user,
        'order' => $order,
        'isAdmin' => false]);
});