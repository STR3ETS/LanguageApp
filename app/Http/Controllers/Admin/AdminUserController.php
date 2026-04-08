<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount([
            'subscriptions' => fn($q) => $q->active(),
            'progress' => fn($q) => $q->whereNotNull('completed_at'),
        ])->with('streak');

        if ($search = $request->get('search')) {
            $query->where(fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['subscriptions.language', 'streak']);
        $progress = $user->progress()->with('lesson.level.language')->whereNotNull('completed_at')->latest('completed_at')->take(20)->get();

        return view('admin.users.show', compact('user', 'progress'));
    }

    public function toggleAdmin(User $user)
    {
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', $user->name . ($user->is_admin ? ' is now an admin.' : ' is no longer an admin.'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
