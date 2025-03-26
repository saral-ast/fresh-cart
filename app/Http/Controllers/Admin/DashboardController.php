<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $orders = Order::orderBy("created_at","desc")->take(5)->get();
        // dd($orders);
        $totalEarnings = Order::sum("total");
        $totalOrders = Order::count();
        $totalCustomers = User::count();
        // $
    
        
        return view("dashboard.index",[
            "orders" => $orders,
            "totalEarnings" => $totalEarnings,
            "totalOrders" => $totalOrders,
            "totalCustomers" => $totalCustomers,
        ]);
    }
}
