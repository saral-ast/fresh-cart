<?php

namespace App\Http\Controllers\User;

use App\Events\OrderPlaced;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ShippingAddress;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        try {
            $cart = $this->cartService->getCart();
            $total = $this->cartService->getCartTotal();
            $user = Auth::user();

            return view('user.checkout', [
                'cart' => $cart,
                'total' => $total,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('cart.show')
                ->with('error', 'Failed to load checkout page: ' . $e->getMessage());
        }
    }

    public function checkout(Request $request)
    {
        try {
            // dd($request->all());
            $user = Auth::user();
            $cart = $this->cartService->getCart();
            
            if (empty($cart)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 400);
            }
          
            // Get address data
            if (!$request->has('saved_address')) {
                // Validate new address input
                $addressData = $request->validate([
                    'address' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'state' => 'required|string|max:255',
                    'country' => 'required|string|max:255',
                    'postal_code' => 'required|string|max:255',
                ]);
            } else {
                // Get saved address
                $address = Address::where('id', $request->saved_address)->first();
                if (!$address) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Address not found'
                    ], 400);
                }
                $addressData = $address->toArray();
                unset($addressData['id']);
            }
            // dd($addressData);

            DB::beginTransaction();
            // Store address data
            $this->orderService->storeAddress($addressData);
            
            // Store cart data
            $this->orderService->storeCart($cart);

            // Store payment data
            $total = $this->cartService->getCartTotal();
            $paymentData = [
                'amount' => $total,
                'status' => 'pending'
            ];
            $this->orderService->storePayment($paymentData);
       
            // dd($total);
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pending'
            ]);
            // dd($order);
         
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
            // dd($order);
        
            
            // Create payment
            Payment::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'amount' => $order->total,
                'status' => 'pending'
            ]);
        

            // Handle address storage
            $addressData['user_id'] = $user->id;
            if ($request->make_default === 'on' && !$request->has('saved_address')) {
                Address::create($addressData);
               
            }
            

            
            $addressData['order_id'] = $order->id;
            // dd($addressData);
            // dd($addressData);
            ShippingAddress::create($addressData);
            // dd($order);

            DB::commit();

            // Clear cart and order data
            $this->cartService->clearCart();
            $this->orderService->clearOrderData();
            Log::info('Firing OrderPlaced event for order: ' . $order->id);
            event(new OrderPlaced($order));

            return redirect()
                ->route('order.success', ['order' => $order->id])
                ->with('success', 'Order placed successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()
                ->route('checkout.index')
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('checkout.index')
                ->with('error', 'Failed to process order: ' . $e->getMessage());
        }
    }

    public function success($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            // Ensure the order belongs to the authenticated user
            if ($order->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            return view('user.order-success', ['order' => $order]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('home')
                ->with('error', 'Order not found.');
        } catch (\Exception $e) {
            return redirect()
                ->route('home')
                ->with('error', 'Failed to load order confirmation: ' . $e->getMessage());
        }
    }
}