<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\GeoController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StreetController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\WalkListController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware('auth')->group(function () {
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('votes')->name('votes.')->group(function () {
        Route::get('{district:slug}', [VoteController::class, 'show'])->name('show');
    });
    Route::resource('votes', VoteController::class)->except('show');

    Route::delete('users', [UserController::class, 'bulkDestroy'])->name('users.bulk-destroy');
    Route::resource('users', UserController::class);

    Route::delete('groups', [GroupController::class, 'bulkDestroy'])->name('groups.bulk-destroy');
    Route::put('{group}/assign', [GroupController::class, 'assign'])->name('groups.assign');
    Route::resource('groups', GroupController::class);

    Route::delete('contacts', [ContactController::class, 'bulkDestroy'])->name('contacts.bulk-destroy');
    Route::resource('contacts', ContactController::class);

    Route::prefix('houses')->name('houses.')->group(function () {
        Route::get('bulk-create', [HouseController::class, 'bulkCreate'])->name('bulk-create');
        Route::delete('bulk-destroy', [HouseController::class, 'bulkDestroy'])->name('bulk-destroy');
    });
    Route::resource('houses', HouseController::class);

    Route::delete('streets', [StreetController::class, 'bulkDestroy'])->name('streets.bulk-destroy');
    Route::resource('streets', StreetController::class);

    Route::resource('walk-lists', WalkListController::class);

    Route::post('interactions', [InteractionController::class, 'store'])->name('interactions.store');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'general'])->name('general');
        Route::get('role', [SettingController::class, 'role'])->name('role');
        Route::patch('/', [SettingController::class, 'update'])->name('update');
    });

    Route::get('statistic', StatisticController::class)->name('statistic');
});

Route::prefix('geo')->group(function () {
    Route::post('provinces', [GeoController::class, 'provinces'])->name('geo.provinces');
    Route::post('regencies/{province?}', [GeoController::class, 'regencies'])->name('geo.regencies');
    Route::post('districts/{regency}', [GeoController::class, 'districts'])->name('geo.districts');
    Route::post('villages/{district}', [GeoController::class, 'villages'])->name('geo.villages');
    Route::post('polling-stations/{village}', [GeoController::class, 'pollingStations'])->name('geo.polling-stations');
    Route::post('streets/{village}', [GeoController::class, 'streets'])->name('geo.streets');
    Route::get('assignees', [GeoController::class, 'assignees'])->name('geo.assignees');
});

Route::get('attachments/download', AttachmentController::class)->name('attachments.download');

require __DIR__ . '/auth.php';
