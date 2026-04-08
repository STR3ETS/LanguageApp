<?php

namespace App\Http\Controllers;

use App\Models\UserProgress;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load(['subscriptions.language', 'streak']);

        $activeSubscriptions = $user->subscriptions()->active()->with('language.levels.lessons')->get();

        // Calculate progress per language
        $completedLessonIds = $user->progress()->whereNotNull('completed_at')->pluck('lesson_id');
        foreach ($activeSubscriptions as $sub) {
            $levels = $sub->language->levels;
            $totalLessons = $levels->sum(fn($l) => $l->lessons->count());
            $completedCount = $levels->sum(fn($l) => $l->lessons->filter(fn($ls) => $completedLessonIds->contains($ls->id))->count());
            $sub->progress_percent = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0;
            $sub->completed_count = $completedCount;
            $sub->total_lessons = $totalLessons;

            // Find current CEFR level + status
            $sub->current_cefr = 'A1';
            $sub->cefr_status = 'in_progress'; // in_progress | completed
            $sub->cefr_done = 0;
            $sub->cefr_total = 0;
            foreach ($levels->groupBy('cefr') as $cefr => $cefrLevels) {
                $cefrTotal = $cefrLevels->sum(fn($l) => $l->lessons->count());
                $cefrDone = $cefrLevels->sum(fn($l) => $l->lessons->filter(fn($ls) => $completedLessonIds->contains($ls->id))->count());
                $cefrComplete = $cefrDone === $cefrTotal && $cefrTotal > 0;

                if ($cefrDone > 0 && !$cefrComplete) {
                    // Currently working on this level
                    $sub->current_cefr = $cefr;
                    $sub->cefr_status = 'in_progress';
                    $sub->cefr_done = $cefrDone;
                    $sub->cefr_total = $cefrTotal;
                } elseif ($cefrComplete) {
                    // Completed, check if next one started
                    $sub->current_cefr = $cefr;
                    $sub->cefr_status = 'completed';
                    $sub->cefr_done = $cefrDone;
                    $sub->cefr_total = $cefrTotal;
                }
            }
        }

        $recentProgress = $user->progress()
            ->with('lesson.level.language')
            ->whereNotNull('completed_at')
            ->orderByDesc('completed_at')
            ->limit(5)
            ->get();

        $stats = [
            'total_xp' => $user->streak?->total_xp ?? 0,
            'current_streak' => $user->streak?->current_streak ?? 0,
            'longest_streak' => $user->streak?->longest_streak ?? 0,
            'lessons_completed' => $user->progress()->whereNotNull('completed_at')->count(),
            'languages_active' => $activeSubscriptions->count(),
        ];

        // Weekly activity chart (last 14 days)
        $weeklyActivity = $this->getWeeklyActivity($user->id);

        // Words learned count
        $wordsLearned = $stats['lessons_completed'] * 6; // ~6 words per lesson

        // Next milestone
        $xpMilestones = [100, 250, 500, 1000, 2500, 5000, 10000];
        $nextMilestone = collect($xpMilestones)->first(fn($m) => $m > $stats['total_xp']) ?? 10000;
        $milestoneProgress = $nextMilestone > 0 ? min(100, round(($stats['total_xp'] / $nextMilestone) * 100)) : 100;

        return view('dashboard', compact(
            'activeSubscriptions', 'recentProgress', 'stats',
            'weeklyActivity', 'wordsLearned', 'nextMilestone', 'milestoneProgress'
        ));
    }

    private function getWeeklyActivity(int $userId): array
    {
        $days = 14;
        $start = now()->subDays($days - 1)->startOfDay();

        $completions = UserProgress::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', $start)
            ->selectRaw('DATE(completed_at) as date, COUNT(*) as count, SUM(xp_earned) as xp')
            ->groupByRaw('DATE(completed_at)')
            ->pluck('count', 'date')
            ->toArray();

        $result = [];
        foreach (CarbonPeriod::create($start, now()) as $date) {
            $key = $date->toDateString();
            $result[] = [
                'date' => $key,
                'label' => $date->format('D'),
                'short' => $date->format('j'),
                'count' => $completions[$key] ?? 0,
                'is_today' => $date->isToday(),
            ];
        }

        return $result;
    }
}
