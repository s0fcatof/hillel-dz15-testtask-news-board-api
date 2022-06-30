<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

// Users
Route::prefix('users')->group(function () {
    // Public routes
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/id{user}', [UserController::class, 'show']);
    Route::get('/{user:username}', [UserController::class, 'show']);

    // Protected routes
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::patch('/id{user}', [UserController::class, 'update'])->middleware('can:update,user');
        Route::patch('/{user:username}', [UserController::class, 'update'])->middleware('can:update,user');
        Route::delete('/id{user}', [UserController::class, 'destroy'])->middleware('can:delete,user');
        Route::delete('/{user:username}', [UserController::class, 'destroy'])->middleware('can:delete,user');
    });
});

// Posts
Route::prefix('posts')->group(function () {
    // Public routes
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{post}', [PostController::class, 'show']);

    // Protected routes
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/', [PostController::class, 'store']);
        Route::patch('/{post}', [PostController::class, 'update'])->middleware('can:update,post');
        Route::delete('/{post}', [PostController::class, 'destroy'])->middleware('can:delete,post');
        Route::post('/{post}/upvote', [PostController::class, 'upvote'])->middleware('can:upvote,post');
    });
});

// Comments
Route::prefix('comments')->group(function () {
    // Public routes
    Route::get('/', [CommentController::class, 'index']);
    Route::get('/{comment}', [CommentController::class, 'show']);

    // Protected routes
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/', [CommentController::class, 'store']);
        Route::patch('/{comment}', [CommentController::class, 'update'])->middleware('can:update,comment');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->middleware('can:delete,comment');
    });
});

