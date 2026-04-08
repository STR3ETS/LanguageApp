<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Language;
use App\Models\Lesson;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserProgress;
use Carbon\CarbonPeriod;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_users_week' => User::where('created_at', '>=', now()->subWeek())->count(),
            'total_subscriptions' => Subscription::active()->count(),
            'total_lessons_completed' => UserProgress::whereNotNull('completed_at')->count(),
            'total_languages' => Language::active()->count(),
            'total_blog_posts' => BlogPost::published()->count(),
            'total_levels' => Lesson::count(),
        ];

        // User registrations last 30 days
        $registrations = [];
        $regData = User::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupByRaw('DATE(created_at)')
            ->pluck('count', 'date')
            ->toArray();

        foreach (CarbonPeriod::create(now()->subDays(29), now()) as $date) {
            $key = $date->toDateString();
            $registrations[] = ['date' => $date->format('M j'), 'count' => $regData[$key] ?? 0];
        }

        // Most popular languages
        $popularLanguages = Language::withCount(['subscriptions' => fn($q) => $q->active()])
            ->orderByDesc('subscriptions_count')
            ->take(5)
            ->get();

        // Recent users
        $recentUsers = User::latest()->take(10)->get();

        // Recent activity
        $recentActivity = UserProgress::with(['user', 'lesson.level.language'])
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'registrations', 'popularLanguages', 'recentUsers', 'recentActivity'));
    }
}
