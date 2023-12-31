<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::apiResource('articles', ArticleController::class)->only([
    'index', 'show'
]);
Route::apiResource('articles.comments', CommentController::class)->only([
    'index', 'show'
]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('user/articles', [ArticleController::class, 'index']);
    Route::get('user/articles/{id}', [ArticleController::class, 'show']);
    Route::apiResource('articles', ArticleController::class)->only([
        'store', 'update', 'destroy'
    ]);
    Route::apiResource('articles.comments', CommentController::class)->only([
        'store'
    ]);

    Route::get('articles/{id}/review', [ArticleController::class, 'reviewArticle']);
    Route::get('articles/{id}/approve', [ArticleController::class, 'approveArticle']);

});
