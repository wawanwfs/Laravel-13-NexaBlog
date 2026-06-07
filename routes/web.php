<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ─────────────────────────────────────────
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/about',   [LandingController::class, 'about'])->name('about');
Route::get('/privacy', [LandingController::class, 'privacy'])->name('privacy');
Route::get('/terms',   [LandingController::class, 'terms'])->name('terms');
Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
Route::post('/contact', [LandingController::class, 'sendContact'])->name('contact.send');

// Blog (public)
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/category/{slug}', [PostController::class, 'category'])->name('category');
    Route::get('/{slug}', [PostController::class, 'show'])->name('show');
    Route::post('/{post}/comments', [PostController::class, 'storeComment'])->name('comments.store');
});

// ── Guest-only Routes ─────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password',  [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendLink'])->name('password.email');
    Route::get('/reset-password/{token}',  [ResetPasswordController::class, 'showForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// ── Authenticated User Routes ─────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (redirect based on role)
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // User Dashboard & Profile
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/profile',   [ProfileController::class, 'edit'])->name('user.profile');
    Route::patch('/user/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::patch('/user/password', [ProfileController::class, 'updatePassword'])->name('user.password.update');
});

// ── Admin Routes (admin + superadmin) ────────────────────
Route::middleware(['auth', 'role:admin,superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Posts
    Route::resource('posts', Admin\PostController::class);

    // Categories
    Route::resource('categories', Admin\CategoryController::class);

    // Tags
    Route::resource('tags', Admin\TagController::class)->only(['index', 'store', 'destroy']);
    Route::get('tags', [Admin\TagController::class, 'index'])->name('tags.index');

    // Comments (moderation)
    Route::get('comments', [Admin\CommentController::class, 'index'])->name('comments.index');
    Route::patch('comments/{comment}/approve', [Admin\CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('comments/{comment}', [Admin\CommentController::class, 'reject'])->name('comments.reject');
});

// ── Superadmin Routes (superadmin only) ──────────────────
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    Route::resource('users', Admin\UserController::class);
});
