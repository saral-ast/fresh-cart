<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->order()->with(['ordersitem', 'address'])->latest()->get();
        $shippingAddresses = $user->shippingAddresses()->latest()->get();
        return view('user.profile.index', compact('user', 'orders', 'shippingAddresses'));
    }
    public function update(Request $request){
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return response()->json(['message' => 'Profile updated successfully!']);;
    }
}