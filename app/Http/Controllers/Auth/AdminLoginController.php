<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function create()
    {
        return view('auth.admin-login');
    }

    public function store(Request $request)
    {
    
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::guard('admin')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.',
            ]);
        }

        $request->session()->regenerate();
        return redirect()->route('dashboard.index');
    }

    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
