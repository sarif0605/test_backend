<?php

use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\CategoryAPIController;
use App\Http\Controllers\API\CommentAPIController;
use App\Http\Controllers\API\ContentAPIController;
use App\Http\Controllers\API\FavoriteAPIController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('category-all', [CategoryAPIController::class, 'showAll']); // done
    Route::get('show-category/{id}', [CategoryAPIController::class, 'show']); // done
    Route::get('category', [CategoryAPIController::class, 'index']); // done
    Route::get('content-three', [ContentAPIController::class, 'showThreeContent']); // done
    Route::get('content', [ContentAPIController::class, 'index']); // done
    Route::get('content/{id}', [ContentAPIController::class, 'show']); // done
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthAPIController::class, 'register']); //done
        Route::post('login', [AuthAPIController::class, 'login']); // done
        Route::post('logout', [AuthAPIController::class, 'logout'])->middleware('auth:api'); // done
    });

    Route::middleware('auth:api')->group(function () {
        Route::post('add-favorite', [FavoriteAPIController::class, 'addFavorite']);
        Route::get('get-favorite', [FavoriteAPIController::class, 'getFavorites']);
        Route::delete('remove-favorite', [FavoriteAPIController::class, 'removeFavorite']);
        Route::post('comment', [CommentAPIController::class, 'store']);
    });
});