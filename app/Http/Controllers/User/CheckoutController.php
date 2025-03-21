<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }
    public function index(){
        $cart = $this->cartService->getCart();
        $total = $this->cartService->getCartTotal();
        $user = Auth::user();
        return view('user.checkout', ['cart' => $cart, 'total' => $total,'user' => $user]);
    }

    public function checkout(Request $request)
    {
        try {
            $user = Auth::user();
            $cart = $this->cartService->getCart();
            if (empty($cart)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 400);
            }

            // Store address data in session
            $addressData = [
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
            ];
            $this->orderService->storeAddress($addressData);
            
            // Store cart data in session
            $this->orderService->storeCart($cart);
            
            // Store payment data in session
            $paymentData = [
                'amount' => $this->cartService->getCartTotal(),
                'status' => 'pending'
            ];
            $this->orderService->storePayment($paymentData);
            
            // Now create the actual order in database
            DB::beginTransaction();
            
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $this->cartService->getCartTotal(),
                'status' => 'pending'
            ]);

            // Create order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            // Create payment
            $payment = Payment::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'amount' => $order->total,
                'status' => 'pending'
            ]);

            Address::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
            ]);

            DB::commit();
            $this->cartService->clearCart();
            $this->orderService->clearOrderData();

            return redirect()->route('order.success', ['order' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('user.order-success', ['order' => $order]);
    }
}