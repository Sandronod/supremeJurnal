<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(string $locale): View
    {
        return view('contact', ['setting' => Setting::current()]);
    }
}
