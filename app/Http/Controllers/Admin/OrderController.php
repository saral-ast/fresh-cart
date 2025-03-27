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
        try{
            $orders = Order::with(['user', 'ordersitem'])->latest()->paginate(8);
            return view('admin.orders.index', compact('orders'));
        }catch(\Exception $e){
            return redirect()->route('admin.orders.index')->with('error','Something went wrong');
        }
    }

    /**
     * Show the details of a specific order.
     */
    public function show(Order $order)
    {
       try{
        $order->load(['user', 'ordersitem.product', 'address', 'payment']);
    
        return response()->json([
            'success' => true,
            'order' => $order,
        ]);
       }catch(\Exception $e){
        return response()->json([
            'success' => false,
            'message' => 'Order not found'
        ], 404);
       }
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        try{
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
        }catch(\Exception $e){
            return response()->json([
               'success' => false,
               'message' => 'Something went wrong'
            ], 500);
        }
    }
}