<?php

use App\Http\Controllers\Api\Project\CreateProjectController;
use App\Http\Controllers\Api\Project\IndexProjectController;
use App\Http\Controllers\Api\Project\RemoveProjectController;
use App\Http\Controllers\Api\Project\ShowProjectController;
use App\Http\Controllers\Api\Project\UpdateProjectController;
use App\Http\Controllers\Api\TimeTracking\StartTimeTrackingController;
use App\Http\Controllers\Api\TimeTracking\StopTimeTrackingController;
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

    Route::name('projects.time_tracking.')->prefix('/projects')->group(function () {
        Route::post('/{project}/start', StartTimeTrackingController::class)
            ->name('start');
        Route::post('/{project}/stop', StopTimeTrackingController::class)
            ->name('stop');
    });

    Route::name('projects.')->group(function () {
        Route::get('/projects', IndexProjectController::class)
            ->name('index');

        Route::post('/projects', CreateProjectController::class)
            ->can('create', Project::class)
            ->name('create');

        Route::put('/projects/{project}', UpdateProjectController::class)
            ->can('update', 'project')
            ->name('update');

        Route::get('/projects/{project}', ShowProjectController::class)
            ->name('show')
            ->can('view', 'project')
            ->name('show');

        Route::delete('/projects/{project}', RemoveProjectController::class)
            ->can('delete', 'project')
            ->name('delete');
    });
});
