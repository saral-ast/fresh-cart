<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StaticPage extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'is_active'];

    /**
     * Set the slug attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }
}