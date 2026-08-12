<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', ['setting' => Setting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $setting = Setting::current();

        $data = $request->validate([
            'site_name_ka' => ['required', 'string', 'max:255'],
            'site_name_en' => ['required', 'string', 'max:255'],
            'issn' => ['nullable', 'string', 'max:50'],
            'copyright_text_ka' => ['nullable', 'string', 'max:255'],
            'copyright_text_en' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'address_ka' => ['nullable', 'string', 'max:255'],
            'address_en' => ['nullable', 'string', 'max:255'],
            'map_embed_url' => ['nullable', 'url', 'max:2000'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
        ]);

        $setting->update($data);

        return redirect()->route('admin.settings.edit')->with('status', 'settings-updated');
    }
}
