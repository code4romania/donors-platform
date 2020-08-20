<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::resource('donors', 'DonorController');
Route::resource('domains', 'DomainController');
Route::resource('grants', 'GrantController');
Route::resource('grants/{grant}/projects', 'ProjectController');
Route::resource('managers', 'GrantManagerController');

Route::resource('grantees', 'GranteeController');
Route::resource('users', 'UserController');
