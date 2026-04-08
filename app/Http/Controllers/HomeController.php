<?php

namespace App\Http\Controllers;

use App\Models\Language;

class HomeController extends Controller
{
    public function index()
    {
        $languages = Language::active()->orderBy('sort_order')->get();

        return view('welcome', compact('languages'));
    }
}
