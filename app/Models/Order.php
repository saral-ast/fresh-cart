<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    protected $guarded = [];

    public function ordersitem(){
        return $this->hasMany(OrderItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function address(){
        return $this->hasOne( ShippingAddress::class);
    }
    
    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
