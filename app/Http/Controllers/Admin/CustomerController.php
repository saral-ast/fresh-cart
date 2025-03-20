<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    /**
     * Show the form for creating the resource. 
     */
    public function index(){
        $customers = User::latest()->paginate(5);
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
    public function store(CustomerRequest $request)
    {
  
        // dd($request->all());
        $request->validated();
        $customer = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password'=> bcrypt($request->password),
            'status' => (bool)$request->status,
        ];
        // dd($customer);
        User::create($customer);
        return redirect()->route('admin.customers')->with('success','Customer created successfully');
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
    public function update(CustomerRequest $request, User $customer)
    {
       
        $request->validated();
         $customer->update([
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'status' => (bool)request('status'),
            'password'=> bcrypt($request->password),
        ]);
        return redirect()->route('admin.customers')->with('success','Customer updated successfully');   
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(User $customer)
    {
        // dd($customer);
        $customer->delete();
        return redirect()->route('admin.customers')->with('success','Customer deleted successfully');
    }
}
