<?php

namespace App\Http\Controllers;

use App\Models\Language;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::active()->orderBy('sort_order')->get();

        return view('languages.index', compact('languages'));
    }

    public function show(Language $language)
    {
        $language->load('levels.lessons');

        return view('languages.show', compact('language'));
    }
}
