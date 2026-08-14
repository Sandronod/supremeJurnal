<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Homepage: shows the "About the Journal" text per the spec.
     */
    public function home(string $locale): View
    {
        $page = Page::where('slug', 'about')->firstOrFail();

        return view('pages.show', ['page' => $page]);
    }

    public function show(string $locale, string $slug): View
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('pages.show', ['page' => $page]);
    }
}
