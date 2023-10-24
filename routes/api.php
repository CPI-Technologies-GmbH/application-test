<?php

use App\Models\Project;
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

Route::get('/', function () {
    return 'Hello World!';
});
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    Route::name('projects.')->group(function () {
        Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('index');

        Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'create'])->can(
            'create',
            Project::class
        )->name('create');

        Route::put('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'update'])
            ->can(
                'update',
                'project'
            )
            ->name('update');

        Route::get('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'show'])->name('show')->can(
            'view',
            'project'
        )->name('show');
        Route::delete('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'remove'])->can(
            'delete',
            'project'
        )->name('delete');
    });
});
