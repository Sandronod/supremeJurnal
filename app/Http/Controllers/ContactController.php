<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact', ['setting' => Setting::current()]);
    }
}
