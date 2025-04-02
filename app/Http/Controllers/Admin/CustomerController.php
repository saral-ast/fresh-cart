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
        try{
            $customers = User::latest()->paginate(5);
            // dd($customers);
            return view('admin.customer.index', ['customers' => $customers]);
        }catch(\Exception $e){
            return redirect()->route('admin.customers')->with('error','Something went wrong');
        }
    }
    public function create()
    {
        try{
            return view('admin.customer.create');
        }catch(\Exception $e){
            return redirect()->route('admin.customers')->with('error','Something went wrong');
        }
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
  
        // dd($request->all());
        try{
            $request->validated();
            $customer = [
                'name' => request('name'),
                'email' => request('email'),
                'phone' => request('phone'),
                'status' => (bool)request('status'),
                'password'=> bcrypt(request('password')),
            ];
            // dd($customer);
            User::create($customer);
            return redirect()->route('admin.customers')->with('success','Customer created successfully');
        }catch(\Exception $e){
            return redirect()->route('admin.customers')->with('error','Customer not created');
        }
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit(User $customer)
    {
    //   dd($customer);
        try{
            return view('admin.customer.edit', ['customer' => $customer]);
        }catch(\Exception $e){
            return redirect()->route('admin.customers')->with('error','Something went wrong');
        }   
    }

    /**
     * Update the resource in storage.
     */
    public function update(CustomerRequest $request, User $customer)
    {
       try{
        // dd($request->all());
        $request->validated();
         $customer->update([
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'status' => request('status') == 'true' ? 'active' : 'inactive',
            // 'password'=> bcrypt($request->password),
        ]);
        // dd($customer);
        return redirect()->route('admin.customers')->with('success','Customer updated successfully');   

       }
       catch(\Exception $e){
        return redirect()->route('admin.customers')->with('error', $e->getMessage());
       }
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(User $customer)
    {
        // dd($customer);
        try{
            $customer->delete();
            return redirect()->route('admin.customers')->with('success','Customer deleted successfully');
    
        }catch(\Exception $e){
            return redirect()->route('admin.customers')->with('error','Customer is not deleted');
        }
    }
}
