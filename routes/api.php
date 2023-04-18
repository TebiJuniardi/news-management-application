<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('news-detail', [NewsController::class, 'newsDetail']);
    Route::get('news/{id}', [NewsController::class, 'show']);
    Route::post('news', [NewsController::class, 'store']);
    Route::post('update-news/{id}', [NewsController::class, 'update']);
    Route::delete('delete-news/{id}', [NewsController::class, 'destroy']);
    Route::post('comment', [NewsController::class, 'addComment']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
