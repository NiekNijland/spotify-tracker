<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Spotify\PlaylistStatisticsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/griekenland', '/1XSciH5yuuecWWraLGMO38');
Route::redirect('/amerika', '/1EcMDsGoy0PvQjBkLWB9mv');

Route::get('/', HomeController::class);
Route::get('/{playlistId}/{page?}', PlaylistStatisticsController::class)->name('spotify.playlist-statistics');
