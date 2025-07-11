<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PermissionsSeeder extends Seeder
{
    

        public function run(): void
        {
            $permissions = [
                'super admin',
                'Products',
                'Categories',
                'Orders',
                'Customers',
                'Admins',
                'StaticBlocks',
                'StaticPages',
                'Roles',
                'Permissions',
            ];
    
            // Insert or update permissions
            foreach ($permissions as $permName) {
                Permission::updateOrCreate(
                    ['permission' => $permName]
                );
            }
    
            $superAdmin = Permission::find(1);
    
           
            // Assign all permissions to admin_id = 1
            $admin = Role::find(1);
            if ($admin) {
                $admin->permissions()->sync($superAdmin);
            }
        }
    
    
}