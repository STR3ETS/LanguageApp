<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LearnController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLanguageController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');
Route::get('/languages/{language:slug}', [LanguageController::class, 'show'])->name('languages.show');
Route::view('/pricing', 'pages.pricing')->name('pricing');
Route::view('/how-it-works', 'pages.how-it-works')->name('how-it-works');
Route::view('/about', 'pages.about')->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::view('/contact', 'pages.contact')->name('contact');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Learning
    Route::get('/learn', [LearnController::class, 'index'])->name('learn.index');
    Route::get('/learn/{slug}', [LearnController::class, 'language'])->name('learn.language');
    Route::get('/learn/lesson/{lesson}', [LearnController::class, 'lesson'])->name('learn.lesson');
    Route::get('/learn/lesson/{lesson}/review', [LearnController::class, 'review'])->name('learn.review');
    Route::post('/learn/lesson/{lesson}/complete', [LearnController::class, 'complete'])->name('learn.complete');

    // Subscriptions
    Route::post('/subscribe/{language}', [SubscriptionController::class, 'store'])->name('subscribe');
    Route::delete('/subscribe/{language}', [SubscriptionController::class, 'destroy'])->name('unsubscribe');

    // Tour
    Route::post('/tour/complete', function () {
        auth()->user()->update(['tour_completed' => true]);
        return response()->json(['ok' => true]);
    })->name('tour.complete');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/blog', [AdminBlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [AdminBlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [AdminBlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{post}/edit', [AdminBlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}', [AdminBlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}', [AdminBlogController::class, 'destroy'])->name('blog.destroy');

    Route::get('/languages', [AdminLanguageController::class, 'index'])->name('languages.index');
    Route::get('/languages/{language}', [AdminLanguageController::class, 'show'])->name('languages.show');
});

require __DIR__.'/auth.php';
