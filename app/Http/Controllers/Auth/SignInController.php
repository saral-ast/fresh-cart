<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class SignInController extends Controller
{
    public function create()
    {
        try {
            return view('auth.register');
        } catch (\Exception $e) {
            return redirect()
                ->route('user.signin')
                ->with('error', 'Failed to load registration page: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'phone' => 'required|string|max:20',
                'password' => ['required', 'confirmed', Password::min(8)]
            ]);

            $attributes = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
            ];

            $user = User::create($attributes);
            
            Auth::login($user);
            $request->session()->regenerate();

            return redirect('/')
                ->with('success', 'Registration successful. Welcome!');
        } catch (ValidationException $e) {
            throw $e; // Re-throw validation exceptions for Laravel's default handling
        } catch (\Exception $e) {
            return redirect()
                ->route('user.signin')
                ->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

 




}