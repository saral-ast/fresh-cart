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
                ->route('cart.index')
                ->with('error', 'Failed to load checkout page: ' . $e->getMessage());
        }
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

            // Validate request data
            $request->validate([
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'postal_code' => 'required|string|max:20',
            ]);

            DB::beginTransaction();

            // Store address data
            $addressData = [
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
            ];
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

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
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
            Payment::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'amount' => $order->total,
                'status' => 'pending'
            ]);

            // Create address
            Address::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
            ]);

            DB::commit();

            // Clear cart and order data
            $this->cartService->clearCart();
            $this->orderService->clearOrderData();

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