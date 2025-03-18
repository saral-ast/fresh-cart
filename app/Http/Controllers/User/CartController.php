<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth;


class CartController extends Controller
{
    public function index()
    {
        return $this->show();
    }

    public function create(): never
    {
        abort(404);
    }

    public function store(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // if (!auth()->check()) {
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Please login to add items to cart.'
            // ], 401);
        // }

        $cart = session()->get('cart', []);
        
        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "description" => $product->description,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cartCount' => count($cart)
        ]);
    }

    public function show()
    {
        $cart = session()->get('cart', []);
       
        return view('user.cart.index', compact('cart'));
    }
}

