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
    Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'create']);
    Route::get('/projectsshow/{id}', [App\Http\Controllers\ProjectController::class, 'show']);
    Route::post('/projectsupdate/{id}', [App\Http\Controllers\ProjectController::class, 'update']);
    Route::delete('/projectsdestroy/{id}', [App\Http\Controllers\ProjectController::class, 'destroy']);
    Route::get('/projectsindex', [App\Http\Controllers\ProjectController::class, 'index']);
    Route::get('/timetrackingsindex', [App\Http\Controllers\TimeTrackingController::class, 'index']);
    Route::post('/timetrackingsstore', [App\Http\Controllers\TimeTrackingController::class, 'store']);
    Route::get('/timetrackingsshow/{id}', [App\Http\Controllers\TimeTrackingController::class, 'show']);
    Route::post('/timetrackingsupdate/{id}', [App\Http\Controllers\TimeTrackingController::class, 'update']);
    Route::delete('/timetrackingsdestroy/{id}', [App\Http\Controllers\TimeTrackingController::class, 'destroy']);
    Route::post('/timetrackingsstart/{id}', [App\Http\Controllers\TimeTrackingController::class, 'startTracking']);
    Route::post('/timetrackingsstop/{id}', [App\Http\Controllers\TimeTrackingController::class, 'stopTracking']);   
});
