<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Lesson;
use App\Models\Streak;
use App\Models\UserProgress;
use App\Services\TranslationService;
use App\Services\VocabularyService;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    public function __construct(
        private VocabularyService $vocabulary,
        private TranslationService $translator,
    ) {}

    public function index(Request $request)
    {
        $subscriptions = $request->user()->subscriptions()
            ->active()
            ->with('language')
            ->get();

        if ($subscriptions->isEmpty()) {
            return redirect()->route('languages.index')
                ->with('info', 'Unlock a language to start learning.');
        }

        // For each subscription, get progress info
        $languageProgress = $subscriptions->map(function ($sub) use ($request) {
            $language = $sub->language;
            $language->load('levels.lessons');

            $completedLessonIds = $request->user()->progress()
                ->whereNotNull('completed_at')
                ->whereHas('lesson.level', fn($q) => $q->where('language_id', $language->id))
                ->pluck('lesson_id');

            $totalLessons = $language->levels->sum(fn($level) => $level->lessons->count());
            $completedCount = $completedLessonIds->count();

            // Find next lesson
            $nextLesson = null;
            foreach ($language->levels as $level) {
                foreach ($level->lessons as $lesson) {
                    if (!$completedLessonIds->contains($lesson->id)) {
                        $nextLesson = $lesson;
                        break 2;
                    }
                }
            }

            return (object) [
                'language' => $language,
                'total_lessons' => $totalLessons,
                'completed_count' => $completedCount,
                'progress_percent' => $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0,
                'next_lesson' => $nextLesson,
            ];
        });

        return view('learn.index', compact('languageProgress'));
    }

    public function language(Request $request, string $slug)
    {
        $language = Language::where('slug', $slug)->firstOrFail();

        // Check subscription
        $hasSubscription = $request->user()->subscriptions()
            ->where('language_id', $language->id)
            ->where('status', 'active')
            ->exists();

        if (!$hasSubscription) {
            return redirect()->route('languages.show', $language->slug)
                ->with('info', 'Unlock this language to start learning.');
        }

        $language->load('levels.lessons');

        $completedLessonIds = $request->user()->progress()
            ->whereNotNull('completed_at')
            ->pluck('lesson_id');

        // Build unlocked lesson IDs: a lesson is unlocked if ALL previous lessons are completed
        $unlockedLessonIds = collect();
        $allLessonsOrdered = [];
        $previousCefrComplete = true;

        foreach ($language->levels->groupBy('cefr') as $cefr => $cefrLevels) {
            $cefrLessonIds = [];

            foreach ($cefrLevels as $level) {
                foreach ($level->lessons as $lesson) {
                    $cefrLessonIds[] = $lesson->id;
                }
            }

            // All lessons in this CEFR block are locked if previous CEFR isn't complete
            if (!$previousCefrComplete) {
                $allLessonsOrdered = array_merge($allLessonsOrdered, array_map(fn($id) => ['id' => $id, 'locked' => true], $cefrLessonIds));
            } else {
                foreach ($cefrLessonIds as $id) {
                    $allLessonsOrdered[] = ['id' => $id, 'locked' => false];
                }
            }

            // Check if this entire CEFR block is complete
            $previousCefrComplete = collect($cefrLessonIds)->every(fn($id) => $completedLessonIds->contains($id));
        }

        // Now within each unlocked CEFR: lessons unlock sequentially
        $previousCompleted = true;
        foreach ($allLessonsOrdered as $entry) {
            if ($entry['locked']) continue;

            if ($previousCompleted) {
                $unlockedLessonIds->push($entry['id']);
            }

            $previousCompleted = $completedLessonIds->contains($entry['id']);
        }

        return view('learn.language', compact('language', 'completedLessonIds', 'unlockedLessonIds'));
    }

    public function lesson(Request $request, Lesson $lesson)
    {
        $lesson->load('level.language');
        $language = $lesson->level->language;

        // Check subscription
        $hasSubscription = $request->user()->subscriptions()
            ->where('language_id', $language->id)
            ->where('status', 'active')
            ->exists();

        if (!$hasSubscription) {
            return redirect()->route('languages.show', $language->slug);
        }

        // Check if lesson is unlocked (all previous lessons in this language must be completed)
        $language->load('levels.lessons');
        $completedLessonIds = $request->user()->progress()->whereNotNull('completed_at')->pluck('lesson_id');

        $isUnlocked = false;
        $previousCefrComplete = true;

        foreach ($language->levels->groupBy('cefr') as $cefr => $cefrLevels) {
            $cefrLessonIds = $cefrLevels->flatMap(fn($l) => $l->lessons->pluck('id'));

            if (!$previousCefrComplete) {
                // This CEFR is locked; if our lesson is here, deny
                if ($cefrLessonIds->contains($lesson->id)) {
                    return redirect()->route('learn.language', $language->slug)
                        ->with('info', 'Complete the previous level first to unlock this lesson.');
                }
            } else {
                // Check sequential unlock within this CEFR
                foreach ($cefrLessonIds as $id) {
                    if ($id === $lesson->id) {
                        $isUnlocked = true;
                        break 2;
                    }
                    if (!$completedLessonIds->contains($id)) {
                        break 2; // This lesson isn't done, so nothing after it is unlocked
                    }
                }
            }

            $previousCefrComplete = $cefrLessonIds->every(fn($id) => $completedLessonIds->contains($id));
        }

        // Already completed lessons are always accessible (for review)
        if (!$isUnlocked && !$completedLessonIds->contains($lesson->id)) {
            return redirect()->route('learn.language', $language->slug)
                ->with('info', 'Complete the previous lessons first.');
        }

        $progress = $request->user()->progress()
            ->where('lesson_id', $lesson->id)
            ->first();

        // Generate the full lesson with phases
        $isExam = str_contains($lesson->title, 'Final Exam');
        $uiLang = $request->user()->ui_language ?? 'en';

        if ($isExam) {
            $cefr = $lesson->level->cefr;
            $cefrLevels = $language->levels->where('cefr', $cefr);
            $allWords = [];
            foreach ($cefrLevels as $lvl) {
                foreach ($lvl->lessons as $ls) {
                    if (str_contains($ls->title, 'Exam')) continue;
                    $pairs = $this->vocabulary->getWordPairs(strtolower($ls->title), $language->name);
                    $allWords = array_merge($allWords, $pairs);
                }
            }
            $seen = [];
            $wordPairs = [];
            foreach ($allWords as $p) {
                if (!isset($seen[$p['word']])) {
                    $wordPairs[] = $p;
                    $seen[$p['word']] = true;
                }
            }
            $wordPairs = array_slice($wordPairs, 0, 30);
            $wordPairs = $this->translator->translatePairs($wordPairs, $uiLang);
            $translatedLang = trans_lang($language->slug);
            $steps = $this->buildExamSteps($wordPairs, $language->name, $translatedLang);
        } else {
            $wordPairs = $this->vocabulary->getWordPairs(strtolower($lesson->title), $language->name);
            $wordPairs = $this->translator->translatePairs($wordPairs, $uiLang);
            $translatedLang = trans_lang($language->slug);
            $steps = $this->buildLessonSteps($wordPairs, $language->name, $translatedLang);
        }

        return view('learn.lesson', compact('lesson', 'language', 'steps', 'progress'));
    }

    public function review(Request $request, Lesson $lesson)
    {
        $lesson->load('level.language');
        $language = $lesson->level->language;

        $hasSubscription = $request->user()->subscriptions()
            ->where('language_id', $language->id)
            ->where('status', 'active')
            ->exists();

        if (!$hasSubscription) {
            return redirect()->route('languages.show', $language->slug);
        }

        $progress = $request->user()->progress()
            ->where('lesson_id', $lesson->id)
            ->whereNotNull('completed_at')
            ->first();

        if (!$progress) {
            return redirect()->route('learn.lesson', $lesson);
        }

        // Use exact same lookup as the lesson view
        $wordPairs = $this->vocabulary->getWordPairs(strtolower($lesson->title), $language->name);
        $uiLang = $request->user()->ui_language ?? 'en';
        $wordPairs = $this->translator->translatePairs($wordPairs, $uiLang);

        return view('learn.review', compact('lesson', 'language', 'progress', 'wordPairs'));
    }

    public function complete(Request $request, Lesson $lesson)
    {
        $lesson->load('level.language');
        $user = $request->user();

        $hasSubscription = $user->subscriptions()
            ->where('language_id', $lesson->level->language->id)
            ->where('status', 'active')
            ->exists();

        if (!$hasSubscription) {
            return response()->json(['error' => 'No subscription'], 403);
        }

        $request->validate([
            'score' => 'required|integer|min:0|max:100',
        ]);

        $score = (int) $request->input('score');
        $xpEarned = max(1, (int) round($lesson->xp_reward * ($score / 100)));

        UserProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lesson->id],
            ['xp_earned' => $xpEarned, 'score' => $score, 'completed_at' => now()]
        );

        // Update streak
        $streak = Streak::firstOrCreate(
            ['user_id' => $user->id],
            ['current_streak' => 0, 'longest_streak' => 0, 'total_xp' => 0]
        );

        $today = now()->startOfDay();
        $lastActivity = $streak->last_activity_date ? $streak->last_activity_date->startOfDay() : null;

        if (!$lastActivity || !$lastActivity->equalTo($today)) {
            if ($lastActivity && $lastActivity->equalTo($today->copy()->subDay())) {
                $streak->current_streak += 1;
            } else {
                $streak->current_streak = 1;
            }
            $streak->last_activity_date = $today;
        }

        $streak->total_xp += $xpEarned;
        $streak->longest_streak = max($streak->longest_streak, $streak->current_streak);
        $streak->save();

        // Find next lesson
        $nextLesson = Lesson::where('level_id', $lesson->level_id)
            ->where('sort_order', '>', $lesson->sort_order)
            ->orderBy('sort_order')
            ->first();

        if (!$nextLesson) {
            $nextLevel = $lesson->level->language->levels()
                ->where('sort_order', '>', $lesson->level->sort_order)
                ->orderBy('sort_order')
                ->first();

            if ($nextLevel) {
                $nextLesson = $nextLevel->lessons()->orderBy('sort_order')->first();
            }
        }

        return response()->json([
            'success' => true,
            'xp_earned' => (int) $xpEarned,
            'score' => (int) $score,
            'total_xp' => (int) $streak->total_xp,
            'current_streak' => (int) $streak->current_streak,
            'next_lesson_url' => $nextLesson ? route('learn.lesson', $nextLesson) : null,
            'language_url' => route('learn.language', $lesson->level->language->slug),
        ]);
    }

    private function buildExamSteps(array $wordPairs, string $langName, string $langLabel = ''): array
    {
        $langLabel = $langLabel ?: $langName;
        $steps = [];
        $pairs = collect($wordPairs)->shuffle();

        // No flashcards in exams — straight to questions

        // 6x Multiple choice: What does X mean?
        foreach ($pairs->take(6) as $pair) {
            $wrong = $pairs->where('word', '!=', $pair['word'])->pluck('translation')->shuffle()->take(3)->values()->toArray();
            $steps[] = ['type' => 'multiple_choice', 'question' => __('ui.q_what_does_mean', ['word' => $pair['word']]), 'options' => collect(array_merge([$pair['translation']], $wrong))->shuffle()->values()->toArray(), 'correct' => $pair['translation']];
        }

        // 4x Fill in the blank
        foreach ($pairs->skip(6)->take(4) as $pair) {
            $wrong = $pairs->where('word', '!=', $pair['word'])->pluck('word')->shuffle()->take(3)->values()->toArray();
            $steps[] = ['type' => 'fill_blank', 'sentence' => __("ui.q_fill_blank", ["word" => $pair["translation"], "lang" => $langLabel]), 'blank' => $pair['word'], 'options' => collect(array_merge([$pair['word']], $wrong))->shuffle()->values()->toArray(), 'correct' => $pair['word']];
        }

        // 1x Matching (4 pairs)
        if ($pairs->count() >= 4) {
            $matchPairs = $pairs->skip(10)->take(4)->map(fn($p) => ['word' => $p['word'], 'translation' => $p['translation']])->values()->toArray();
            if (count($matchPairs) >= 4) {
                $steps[] = ['type' => 'matching', 'instruction' => __('ui.match_the_pairs'), 'pairs' => $matchPairs, 'lang' => $langName];
            }
        }

        // 4x Reverse: How do you say X?
        foreach ($pairs->skip(14)->take(4) as $pair) {
            $wrong = $pairs->where('translation', '!=', $pair['translation'])->pluck('word')->shuffle()->take(3)->values()->toArray();
            $steps[] = ['type' => 'multiple_choice', 'question' => __("ui.q_how_do_you_say", ["word" => $pair["translation"], "lang" => $langLabel]), 'options' => collect(array_merge([$pair['word']], $wrong))->shuffle()->values()->toArray(), 'correct' => $pair['word']];
        }

        // 3x True/False
        foreach ($pairs->skip(18)->take(3) as $i => $pair) {
            $isCorrect = $i % 2 === 0;
            $shownTranslation = $isCorrect ? $pair['translation'] : $pairs->where('word', '!=', $pair['word'])->random()['translation'];
            $steps[] = ['type' => 'true_false', 'question' => __("ui.q_is_means", ["word" => $pair["word"], "translation" => $shownTranslation]), 'correct' => $isCorrect ? 'true' : 'false', 'actual_translation' => $pair['translation'], 'lang' => $langName];
        }

        // 2x Listening
        foreach ($pairs->skip(21)->take(2) as $pair) {
            $wrong = $pairs->where('word', '!=', $pair['word'])->pluck('translation')->shuffle()->take(3)->values()->toArray();
            $steps[] = ['type' => 'listening', 'word' => $pair['word'], 'question' => __('ui.what_do_you_hear'), 'options' => collect(array_merge([$pair['translation']], $wrong))->shuffle()->values()->toArray(), 'correct' => $pair['translation'], 'lang' => $langName];
        }

        // 5x Typing
        foreach ($pairs->skip(23)->take(5) as $pair) {
            $steps[] = ['type' => 'typing', 'question' => __("ui.q_type_word_for", ["word" => $pair["translation"], "lang" => $langLabel]), 'correct' => strtolower($pair['word']), 'hint' => mb_substr($pair['word'], 0, 1) . str_repeat('_', max(0, mb_strlen($pair['word']) - 1)), 'lang' => $langName];
        }

        // 1x Final matching
        if ($pairs->count() >= 8) {
            $matchPairs = $pairs->take(4)->map(fn($p) => ['word' => $p['word'], 'translation' => $p['translation']])->values()->toArray();
            $steps[] = ['type' => 'matching', 'instruction' => __('ui.match_the_pairs'), 'pairs' => $matchPairs, 'lang' => $langName];
        }

        return $steps;
    }

    private function buildLessonSteps(array $wordPairs, string $langName, string $langLabel = ''): array
    {
        $langLabel = $langLabel ?: $langName;
        $steps = [];
        $pairs = collect($wordPairs);

        // === PHASE 1: Learn the words (flashcards) ===
        foreach ($wordPairs as $pair) {
            $steps[] = [
                'type' => 'flashcard',
                'word' => $pair['word'],
                'translation' => $pair['translation'],
                'lang' => $langName,
            ];
        }

        $shuffled = $pairs->shuffle()->values();

        // === PHASE 2: Multiple choice — "What does X mean?" (4 options) ===
        foreach ($shuffled->take(3) as $pair) {
            $wrong = $pairs->where('word', '!=', $pair['word'])
                ->pluck('translation')->shuffle()->take(3)->values()->toArray();

            $steps[] = [
                'type' => 'multiple_choice',
                'question' => __('ui.q_what_does_mean', ['word' => $pair['word']]),
                'options' => collect(array_merge([$pair['translation']], $wrong))->shuffle()->values()->toArray(),
                'correct' => $pair['translation'],
            ];
        }

        // === PHASE 3: Matching — connect words to translations ===
        if ($pairs->count() >= 4) {
            $matchPairs = $shuffled->take(4)->map(fn($p) => ['word' => $p['word'], 'translation' => $p['translation']])->values()->toArray();
            $steps[] = [
                'type' => 'matching',
                'instruction' => __('ui.match_the_pairs'),
                'pairs' => $matchPairs,
                'lang' => $langName,
            ];
        }

        // === PHASE 4: Listening — hear the word, pick the right one ===
        foreach ($shuffled->take(2) as $pair) {
            $wrong = $pairs->where('word', '!=', $pair['word'])
                ->pluck('translation')->shuffle()->take(3)->values()->toArray();

            $steps[] = [
                'type' => 'listening',
                'word' => $pair['word'],
                'question' => __('ui.what_do_you_hear'),
                'options' => collect(array_merge([$pair['translation']], $wrong))->shuffle()->values()->toArray(),
                'correct' => $pair['translation'],
                'lang' => $langName,
            ];
        }

        // === PHASE 5: Reverse multiple choice — "How do you say X?" (4 options) ===
        foreach ($shuffled->take(2) as $pair) {
            $wrong = $pairs->where('translation', '!=', $pair['translation'])
                ->pluck('word')->shuffle()->take(3)->values()->toArray();

            $steps[] = [
                'type' => 'multiple_choice',
                'question' => __("ui.q_how_do_you_say", ["word" => $pair["translation"], "lang" => $langLabel]),
                'options' => collect(array_merge([$pair['word']], $wrong))->shuffle()->values()->toArray(),
                'correct' => $pair['word'],
            ];
        }

        // === PHASE 6: Fill in the blank ===
        foreach ($shuffled->take(2) as $pair) {
            $sentence = __("ui.q_fill_blank", ["word" => $pair["translation"], "lang" => $langLabel]);
            $wrong = $pairs->where('word', '!=', $pair['word'])
                ->pluck('word')->shuffle()->take(3)->values()->toArray();

            $steps[] = [
                'type' => 'fill_blank',
                'sentence' => $sentence,
                'blank' => $pair['word'],
                'options' => collect(array_merge([$pair['word']], $wrong))->shuffle()->values()->toArray(),
                'correct' => $pair['word'],
            ];
        }

        // === PHASE 7: True/False — is this translation correct? ===
        foreach ($shuffled->take(2) as $i => $pair) {
            $isCorrect = $i % 2 === 0;
            $shownTranslation = $isCorrect
                ? $pair['translation']
                : $pairs->where('word', '!=', $pair['word'])->random()['translation'];

            $steps[] = [
                'type' => 'true_false',
                'question' => __("ui.q_is_means", ["word" => $pair["word"], "translation" => $shownTranslation]),
                'correct' => $isCorrect ? 'true' : 'false',
                'actual_translation' => $pair['translation'],
                'lang' => $langName,
            ];
        }

        // === PHASE 7: Type the answer ===
        foreach ($shuffled->take(3) as $pair) {
            $steps[] = [
                'type' => 'typing',
                'question' => __("ui.q_type_word_for", ["word" => $pair["translation"], "lang" => $langLabel]),
                'correct' => strtolower($pair['word']),
                'hint' => mb_substr($pair['word'], 0, 1) . str_repeat('_', max(0, mb_strlen($pair['word']) - 1)),
                'lang' => $langName,
            ];
        }

        // === PHASE 8: Second matching round (if enough words) ===
        if ($pairs->count() >= 4) {
            $matchPairs = $shuffled->skip(2)->take(4)->values();
            if ($matchPairs->count() >= 3) {
                $steps[] = [
                    'type' => 'matching',
                    'instruction' => __('ui.match_the_pairs'),
                    'pairs' => $matchPairs->map(fn($p) => ['word' => $p['word'], 'translation' => $p['translation']])->values()->toArray(),
                    'lang' => $langName,
                ];
            }
        }

        return $steps;
    }

}
