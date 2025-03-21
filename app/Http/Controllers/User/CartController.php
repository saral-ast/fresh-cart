<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
// use App\Models\Admin\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
// use Illuminate\Contracts\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
 
    public function store($slug)
    {
        try{
            $result = $this->cartService->addToCart($slug);
            return response()->json($result);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show()
    {
        try{
            $cart = $this->cartService->getCart();
            $total = number_format($this->cartService->getCartTotal(), 2);
            
            return view('user.cart.index', [
                'cart' => $cart,
                'total' => $total,
            ]);
        }catch(\Exception $e){
            return response()->json([
               'success' => false,
               'message' => 'Oops! Something went wrong'
            ], 500);
        }
    }
    
    public function update(Request $request){
       try{
            $slug = $request->slug;
            $newQuantity = $request->quantity;

            $result = $this->cartService->updateCartItem($slug, $newQuantity);
            return response()->json($result);
       }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
       } 
    }
    
    public function destroy($slug){
        try{
            $result = $this->cartService->removeFromCart($slug);
            return response()->json($result);
        }catch(\Exception $e){
            return response()->json([
               'success' => false,
               'message' => $e->getMessage()
            ], 500);
        }
    }
}

