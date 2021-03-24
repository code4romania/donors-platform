<?php

declare(strict_types=1);

use App\Http\Controllers\Front\ChartDataController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('{locale?}')->group(function () {
    Route::get('/chart-data', ChartDataController::class)->name('front.chart-data');

    Route::get('/blog', [PostController::class, 'index'])->name('front.posts');

    Route::get('/blog/{slug}', [PostController::class, 'show'])->name('front.post');

    Route::get('/', [PageController::class, 'index'])->name('front.index');

    Route::get('/{slug}', [PageController::class, 'show'])->name('front.page');
});
