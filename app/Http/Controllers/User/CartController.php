<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth;

class CartController extends Controller
{
 
   public function store(Request $request, $slug)
    {
        try{
            $product = Product::where('slug', $slug)->firstOrFail();    
            $cart = session()->get('cart', []);
            
            if(isset($cart[$product->slug])){
                $cart[$product->slug]['quantity']++;
            } else {
                $cart[$product->slug] = [
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "quantity" => 1,
                    "description" => $product->description,
                    "price" => $product->price,
                    "image" => $product->image
                ];
            }
            
            session()->put('cart', $cart);
    
            // return redirect()->back()->with('success', 'Product added to cart successfully!');
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cartCount' => count($cart)
            ]);
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
            $cart = session()->get('cart', []);
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price']*$item['quantity'];
            }
            // dd($total);
            return view('user.cart.index', [
                'cart' => $cart,
                'total' => number_format($total, 2),
            ]);
        }catch(\Exception $e){
            return response()->json([
               'success' => false,
               'message' => $e->getMessage()
            ], 500);
        }

       
    }
    public function update(Request $request){
       try{
        $slug = $request->slug;
        $newQuantity = $request->quantity;

    // Update session cart (Assuming you're using session-based cart)
        $cart = session()->get('cart', []);

        if (isset($cart[$slug])) {
            $cart[$slug]['quantity'] = $newQuantity;
            session()->put('cart', $cart);

            $newTotal = $cart[$slug]['price'] * $newQuantity;
            $cartTotal = 0;
            foreach ($cart as $item) {
                $cartTotal += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'new_total' => number_format($newTotal, 2),
                'cartTotal' => number_format($cartTotal, 2),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found'], 404);
       }catch(\Exception $e){
        return response()->json([
          'success' => false,
          'message' => $e->getMessage()
        ], 500);
       } 
       
    }
    public function destroy($slug){
        try{
            $cart = session()->get('cart', []);
        
        if (!isset($cart[$slug])) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart.'
            ], 404);
        }

        unset($cart[$slug]);
        session()->put('cart', $cart);
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart successfully!',
            'cartCount' => count($cart),
            'total' => $total
        ]);
        }catch(\Exception $e){
            return response()->json([
               'success' => false,
               'message' => $e->getMessage()
            ], 500);
        }
    }
}

