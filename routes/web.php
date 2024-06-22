<?php

declare(strict_types=1);

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

Route::redirect('/', '/1XSciH5yuuecWWraLGMO38');

Route::get('/{playlistId}', PlaylistStatisticsController::class);
