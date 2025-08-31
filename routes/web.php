<?php

use App\Http\Controllers\EventBookingController;
use App\Http\Controllers\EventController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::resource("events", EventController::class)->only(['index', 'show']);
Route::resource("events.booking", EventBookingController::class)->only(['show', 'create', 'store']);

Route::get("akce", function () {return Inertia::render('Event/Tmp');})->name('akce');
Route::get("akce/pohadkovy-les", function () {return Inertia::render('Event/TmpLes');})->name('akce.pohadkovy-les');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
