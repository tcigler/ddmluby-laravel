<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\EventBookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserInfoController;
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

Route::get("booking/cleanup", [EventBookingController::class, "cleanup"])->name('booking.cleanup');
Route::get(__("routes.user-info") . "/{user_info}/" . __("routes.confirm"), [UserInfoController::class, "confirm"])->name("user-info.confirm");

Route::resource(__("routes.events"), EventController::class)->only(['index', 'show'])
    ->names("events")->parameters([__("routes.events") => 'event']);
Route::resource(__("routes.events.booking"), EventBookingController::class)->only(['create', 'store'])
    ->names("events.booking")->parameters([__("routes.events") => 'event']);
Route::resource(__("routes.booking"), EventBookingController::class)->only(['show', 'destroy'])
    ->names("booking")->parameters([__("routes.booking") => 'booking']);
Route::resource(__("routes.user-info"), UserInfoController::class)->only(['show', 'create', 'store', 'edit', 'update'])
    ->names("user-info")->parameters([__("routes.user-info") => 'user-info']);

//Route::get("akce", function () {return Inertia::render('Event/Tmp');})->name('akce');
//Route::get("akce/pohadkovy-les", function () {return Inertia::render('Event/TmpLes');})->name('akce.pohadkovy-les');


Route::prefix('admin')->name('admin.')->middleware("auth")->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('preview-mail', [AdminController::class, 'previewMail'])->name('preview-mail');
    Route::get("events", [BookingController::class, 'eventsIndex'])->name('events.index');
    Route::get("events/{event}", [BookingController::class, 'eventShow'])->name('events.show');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
