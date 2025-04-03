<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory,Notifiable;
    
    protected $table = 'admin';
    protected $guarded = [];
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
    public function hasPermission($permission){
        if ($this->role->permissions()->where('permission', 'super admin')->exists()) {
            return true;
        }
        // Check if the admin's role has the requested permission
        // dd($permission);
        if($this->role) {
            return $this->role->permissions()->where('permission', $permission)->exists();
        }
        
        return false;
    }
}
