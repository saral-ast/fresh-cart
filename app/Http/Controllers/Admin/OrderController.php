<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with(['user', 'ordersitem'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the details of a specific order.
     */
    public function show(Order $order)
    {
       $order->load(['user', 'ordersitem.product', 'address', 'payment']);
    
        return response()->json([
            'success' => true,
            'order' => $order,
        ]);
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'status' => $order->status
        ]);
    }
}