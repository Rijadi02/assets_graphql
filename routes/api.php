<?php

use App\Http\Controllers\API\AssetController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WorkerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::apiResource('workers',WorkerController::class);
//
// Route::post('/worker/store',WorkerController::class);


    Route::get('/assets', [AssetController::class, 'index'])->middleware('auth:api');
    Route::post('/asset/store', [AssetController::class, 'store'])->middleware('auth:api');
    Route::get('/asset/{id}', [AssetController::class, 'show'])->middleware('auth:api');
    Route::post('/asset/{asset}/update', [AssetController::class, 'update'])->middleware('auth:api');
    Route::delete('/asset/{asset}', [AssetController::class, 'destroy'])->middleware('auth:api');
    Route::post('/assets/import', [AssetController::class, 'import'])->middleware('auth:api');
    Route::get('/assets/{asset}/history', [AssetController::class, 'history'])->middleware('auth:api');


    Route::get('/workers', [WorkerController::class, 'index'])->middleware('auth:api');
    Route::post('/worker/store', [WorkerController::class, 'store'])->middleware('auth:api');
    Route::get('/worker/{id}', [WorkerController::class, 'show'])->middleware('auth:api');
    Route::post('/worker/{worker}/update', [WorkerController::class, 'update'])->middleware('auth:api');
    Route::delete('/worker/{worker}', [WorkerController::class, 'destroy'])->middleware('auth:api');
    Route::get('/worker/{worker}/assets', [WorkerController::class, 'assets'])->middleware('auth:api');
    Route::get('/worker/search/{worker}', [WorkerController::class, 'search'])->middleware('auth:api');
    Route::get('/asset/search/{asset}', [AssetController::class, 'search'])->middleware('auth:api');
    Route::get('/statistics', [AssetController::class, 'statistics'])->middleware('auth:api');


    Route::post('/user/store', [UserController::class, 'store'])->middleware('auth:api');
    Route::post('/users', [UserController::class, 'store'])->middleware('auth:api');

    Route::middleware('auth:api')->post('/user/logout', function (Request $request) {
        $user = Auth::user()->token();
        $user->revoke();
        return 'logged out';
    });
    // Route::get('/home', [WorkerController::class, 'index']);

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
