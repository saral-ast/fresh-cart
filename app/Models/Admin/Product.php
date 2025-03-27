<?php

namespace App\Models\Admin;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\Admin\ProductFactory> */
    use HasFactory;
    protected $guarded = [];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function orderItem(){
        return $this->hasMany(OrderItem::class);
    }   
}
