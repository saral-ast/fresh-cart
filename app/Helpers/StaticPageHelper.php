<?php

namespace App\Helpers;

use App\Models\Admin\StaticPage;

class StaticPageHelper
{
    /**
     * Get a static page by its slug
     *
     * @param string $slug The unique slug of the static page
     * @return StaticPage|null The static page or null if not found
     */
    public static function getPage($slug)
    {
        return StaticPage::where('slug', $slug)
                         ->where('is_active', 1)
                         ->first();
    }
    
    /**
     * Get all active static pages
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of active static pages
     */
    public static function getAllPages()
    {
        return StaticPage::where('is_active', 1)->get();
    }
}