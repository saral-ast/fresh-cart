<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\StaticPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a static page by its slug
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $page = StaticPage::where('slug', $slug)
            ->where('is_active', 1)
            ->firstOrFail();

        return view('user.pages.show', compact('page'));
    }
}