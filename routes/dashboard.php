<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\WelcomeController;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'verify'   => false,
    'register' => false,
]);

Route::get('welcome/{user}', [WelcomeController::class, 'showWelcomeForm'])->name('welcome');
Route::post('welcome/{user}', [WelcomeController::class, 'savePassword']);

Route::middleware('auth')->group(function () {
    Route::get('/', \App\Http\Controllers\DashboardController::class)->name('dashboard');
    Route::get('/help', \App\Http\Controllers\HelpController::class)->name('help');

    Route::post('/currency-select', \App\Http\Controllers\CurrencyController::class)->name('currency.select');

    Route::resource('donors', \App\Http\Controllers\DonorController::class);
    Route::resource('domains', \App\Http\Controllers\DomainController::class);
    Route::resource('grants', \App\Http\Controllers\GrantController::class);
    Route::resource('grants/{grant}/projects', \App\Http\Controllers\ProjectController::class);
    Route::resource('managers', \App\Http\Controllers\GrantManagerController::class);

    Route::resource('grantees', \App\Http\Controllers\GranteeController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);
});
