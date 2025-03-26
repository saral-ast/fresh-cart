<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StaticBlock extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'identifier', 'content', 'is_active'];

    /**
     * Set the slug attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setIdentifierAttribute($value)
    {
        $this->attributes['identifier'] = Str::slug($value);
    }
}