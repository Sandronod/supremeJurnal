<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('admin.pages.index', ['pages' => Page::orderBy('title_en')->get()]);
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title_ka' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'max:255', 'unique:pages,slug'],
            'body_ka' => ['nullable', 'string'],
            'body_en' => ['nullable', 'string'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['title_en']);

        if ($request->hasFile('background_image')) {
            $data['background_image_path'] = $request->file('background_image')->store('pages/backgrounds', 'public');
        }

        unset($data['background_image']);

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('status', 'page-created');
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', ['page' => $page]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $request->validate([
            'title_ka' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'body_ka' => ['nullable', 'string'],
            'body_en' => ['nullable', 'string'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($request->hasFile('background_image')) {
            $data['background_image_path'] = $request->file('background_image')->store('pages/backgrounds', 'public');
        }

        unset($data['background_image']);

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('status', 'page-updated');
    }

    public function destroy(Page $page): RedirectResponse
    {
        abort_if($page->isFixed(), 422, 'This page is used by the main navigation and cannot be deleted.');

        $page->delete();

        return redirect()->route('admin.pages.index')->with('status', 'page-deleted');
    }
}
