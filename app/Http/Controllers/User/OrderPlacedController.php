<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderPlacedController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
 
    public function index(){
        $cart = $this->cartService->getCart();
        $total = $this->cartService->getCartTotal();
        $user = Auth::user();
        return view('user.checkout', ['cart' => $cart, 'total' => $total,'user' => $user]);
    }
    /**
     * Show the form for creating the resource.
     */
    public function create(): never
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $user = Auth::user();
            $cart = $this->cartService->getCart();
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $this->cartService->getCartTotal(),
            ]);

            foreach ($cart as $item){
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            
            Address::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
            ]);
            Payment::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'amount' => $this->cartService->getCartTotal(),
                'payment_method' => $request->payment_method,
            ]);
             
            return view('user.home');

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error', 'Đặt hàng không thành công');
        }

    }

    /**
     * Display the resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }
}
