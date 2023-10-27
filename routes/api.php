<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function() {
    return 'Hello World!';
});

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    // Projects
    Route::resource('/projects', App\Http\Controllers\ProjectController::class)->except(['create', 'edit']);
    // Time track
    Route::prefix('timetrack')->group(function () {
        Route::post('/start', [App\Http\Controllers\TimetrackController::class, 'start']);
        Route::post('/stop', [App\Http\Controllers\TimetrackController::class, 'stop']);
    });
});
