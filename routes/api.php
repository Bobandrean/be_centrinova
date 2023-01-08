<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'create']);
    Route::prefix('public_blog')->group(function () {
        Route::get('/index', [BlogController::class, 'index']);
        Route::get('/detail/{id}', [BlogController::class, 'detail']);
    });
    Route::prefix('public_comment')->group(function () {
        Route::get('/index/{id}', [CommentController::class, 'index']);
        Route::post('/create/{id_blog}', [CommentController::class, 'create']);
    });


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);

        Route::prefix('blog')->group(function () {
            Route::get('/index', [BlogController::class, 'index']);
            Route::post('/create', [BlogController::class, 'create']);
            Route::post('/update/{id}', [BlogController::class, 'update']);
            Route::post('/delete/{id}', [BlogController::class, 'delete']);
            Route::post('/restore/{id}', [BlogController::class, 'restore']);
        });

        Route::prefix('comment')->group(function () {
            Route::get('/index/{id}', [CommentController::class, 'index']);
            Route::post('/create', [CommentController::class, 'create']);
            Route::post('/delete/{id}/{id_blog}', [CommentController::class, 'delete']);
        });
    });
});
