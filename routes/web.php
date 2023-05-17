<?php

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

Route::prefix('game')->group(function() {
    Route::get('/get', [App\Http\Controllers\GamesController::class, 'getGame'])->name('games');
    Route::get('/screenshot/{game}', [App\Http\Controllers\GamesController::class, 'getScreenshot'])->name('screenshot');
    Route::get('/achievement/{game}', [App\Http\Controllers\GamesController::class, 'getAchievement'])->name('achievement');
});

Route::prefix('score')->group(function() {
    Route::get('/get/player/{name}', [App\Http\Controllers\PandaScoreController::class, 'getPlayer'])->name('player');
    Route::get('/get/champion/{champion}', [App\Http\Controllers\PandaScoreController::class, 'getChampion'])->name('champion');
    Route::get('/get/weapon/{weapon}', [App\Http\Controllers\PandaScoreController::class, 'getWeaponValorant'])->name('weapon');
    Route::get('/get/agents', [App\Http\Controllers\PandaScoreController::class, 'getValorantAgents'])->name('agents');

});


Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'delete'])->name('delete');

