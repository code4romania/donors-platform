<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::resource('donors', 'DonorController');
Route::resource('focus-areas', 'FocusAreaController');
Route::resource('grantees', 'GranteeController');

Route::resource('users', 'UserController');
