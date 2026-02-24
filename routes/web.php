<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/logo.png', function () {
    $candidates = [
        public_path('logo.png'),
        base_path('resources/images/logo.png'),
    ];

    foreach ($candidates as $path) {
        if (is_file($path)) {
            return response()->file($path, [
                'Content-Type' => 'image/png',
            ]);
        }
    }

    abort(404);
});

Route::get('/__debug/paths', function () {
    return response()->json([
        'base_path' => base_path(),
        'public_path' => public_path(),
        'logo_public' => [
            'path' => public_path('logo.png'),
            'exists' => is_file(public_path('logo.png')),
        ],
        'logo_resources' => [
            'path' => base_path('resources/images/logo.png'),
            'exists' => is_file(base_path('resources/images/logo.png')),
        ],
        'app_url' => config('app.url'),
    ]);
});

// Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Redirect root to dashboard if authenticated, otherwise to login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});
