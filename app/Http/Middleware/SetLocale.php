<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->ui_language) {
            app()->setLocale($request->user()->ui_language);
        }

        return $next($request);
    }
}
