<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;

// use App\Http\Controllers\ArticlesController;
// use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ArticlesController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [UserController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('/me', [UserController::class, 'aboutMe']);
    Route::group(['prefix' => 'v1'], function () {
        Route::apiResource('/category-post', CategoryController::class);
        Route::apiResource('/articles-post', ArticlesController::class);
    });
});
