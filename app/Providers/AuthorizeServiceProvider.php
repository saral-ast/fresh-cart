<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthorizeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::before(function($admin,$permission){
            $convertedPermission = ucfirst(str_replace('manage_', '', $permission));
            // dd($convertedPermission);
            return $admin->hasPermission($convertedPermission); //if admin has permission then return tru
        });
        // Gate::define('manage_categories',function($admin){
        //     return $admin->hasPermission('Categories');
        // });
        
        // Gate::define('manage_products',function($admin){
        //     return $admin->hasPermission('Products');
        // });
        
        // Gate::define('manage_orders',function($admin){
        //     return $admin->hasPermission('Orders');
        // });
        
        // Gate::define('manage_customers',function($admin){
        //     return $admin->hasPermission('Customers');
        // });
        
        // Gate::define('manage_admins',function($admin){
        //     return $admin->hasPermission('Admins');
        // });
        
        // Gate::define('manage_roles',function($admin){
        //     return $admin->hasPermission('Roles');
        // });
        
        // Gate::define('manage_permissions',function($admin){
        //     return $admin->hasPermission('Permissions');
        // });
        
        // Gate::define('manage_static_blocks',function($admin){
        //     return $admin->hasPermission('Static Blocks');
        // });
        
        // Gate::define('manage_static_pages',function($admin){
        //     return $admin->hasPermission('Static Pages');
        // });
    
    }
}
