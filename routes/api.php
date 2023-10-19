<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
    Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'create']);
    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'getAll']);
    Route::get('/projects/${id}', [App\Http\Controllers\ProjectController::class, 'getOne']);
    Route::patch('/projects', [App\Http\Controllers\ProjectController::class, 'update']);
    Route::delete('/projects', [App\Http\Controllers\ProjectController::class, 'delete']);

    Route::put('/projects/${id}/tracking', [App\Http\Controllers\TimeTrackingFollowingController::class, 'start']);
    Route::delete('/projects/${id}/tracking', [App\Http\Controllers\TimeTrackingFollowingController::class, 'stop']);
    Route::delete('/trackings/${id}');
});
