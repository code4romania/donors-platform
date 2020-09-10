<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::resource('donors', \App\Http\Controllers\DonorController::class);
Route::resource('domains', \App\Http\Controllers\DomainController::class);
Route::resource('grants', \App\Http\Controllers\GrantController::class);
Route::resource('grants/{grant}/projects', \App\Http\Controllers\ProjectController::class);
Route::resource('managers', \App\Http\Controllers\GrantManagerController::class);

Route::resource('grantees', \App\Http\Controllers\GranteeController::class);
Route::resource('users', \App\Http\Controllers\UserController::class);
