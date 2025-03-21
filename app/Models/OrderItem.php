<?php

namespace App\Models;

use App\Models\Admin\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;
    protected $guarded = [];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
