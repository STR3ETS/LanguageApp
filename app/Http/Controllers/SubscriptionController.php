<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Streak;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request, Language $language)
    {
        $request->validate([
            'language_id' => 'exists:languages,id',
        ]);

        $existing = $request->user()->subscriptions()
            ->where('language_id', $language->id)
            ->first();

        if ($existing && $existing->status === 'active') {
            return back()->with('info', "You already have an active subscription for {$language->name}.");
        }

        if ($existing) {
            $existing->update([
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => null,
                'cancelled_at' => null,
            ]);
        } else {
            $request->user()->subscriptions()->create([
                'language_id' => $language->id,
                'status' => 'active',
                'starts_at' => now(),
            ]);
        }

        // Ensure user has a streak record
        if (!$request->user()->streak) {
            Streak::create(['user_id' => $request->user()->id]);
        }

        return redirect()->route('learn.language', $language->slug)
            ->with('success', "You unlocked {$language->name}! Let's start learning.");
    }

    public function destroy(Request $request, Language $language)
    {
        $subscription = $request->user()->subscriptions()
            ->where('language_id', $language->id)
            ->where('status', 'active')
            ->firstOrFail();

        $subscription->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', "Your {$language->name} subscription has been cancelled.");
    }
}
