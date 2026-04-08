<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Level;
use App\Models\Lesson;
use Illuminate\Http\Request;

class AdminLanguageController extends Controller
{
    public function index()
    {
        $languages = Language::withCount(['levels', 'subscriptions' => fn($q) => $q->active()])
            ->with(['levels' => fn($q) => $q->withCount('lessons')])
            ->orderBy('sort_order')
            ->get();

        return view('admin.languages.index', compact('languages'));
    }

    public function show(Language $language)
    {
        $language->load(['levels' => fn($q) => $q->withCount('lessons')->orderBy('sort_order'), 'levels.lessons']);

        return view('admin.languages.show', compact('language'));
    }
}
