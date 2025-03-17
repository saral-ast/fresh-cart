<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function index(Request $request){
        $customers = User::all();
        // dd($customers);
        return view('admin.customer.index', ['customers' => $customers]);
    }
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'email'=> 'required||unique:users',
            'password'=> 'required|confirmed', 
        ]);
        $customer = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password'=> bcrypt($request->password),
            'status' => $request->status,
        ];
        // dd($customer);
        User::create($customer);
        return redirect()->route('admin.customers');
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
    public function edit(User $customer)
    {
    //   dd($customer);
        return view('admin.customer.edit', ['customer' => $customer]);   
    }

    /**
     * Update the resource in storage.
     */
    public function update(User $customer)
    {
       $customer->update([
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'status' => request('status'),
        ]);
        return redirect()->route('admin.customers');   
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(User $customer)
    {
        // dd($customer);
        $customer->delete();
        return redirect()->route('admin.customers');
    }
}
