<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
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

Route::prefix('users')->group(function () {
  Route::get('/', [UserController::class, 'index']);
  Route::post('/', [UserController::class, 'store']);
  Route::get('/{id}', [UserController::class, 'show']);
  Route::put('/{id}', [UserController::class, 'update']);
  Route::delete('/{id}', [UserController::class, 'delete']);
});

Route::prefix('category')->group(function () {
  Route::get('/', [CategoryController::class, 'index']);
  Route::post('/', [CategoryController::class, 'store']);
  Route::get('/{id}', [CategoryController::class, 'show']);
  Route::put('/{id}', [CategoryController::class, 'update']);
  Route::delete('/{id}', [CategoryController::class, 'delete']);
});

Route::prefix('post')->group(function () {
  Route::get('/', [PostController::class, 'index']);
  Route::post('/', [PostController::class, 'store']);
  Route::get('/{id}', [PostController::class, 'show']);
  Route::put('/{id}', [PostController::class, 'update']);
  Route::delete('/{id}', [PostController::class, 'delete']);
});

Route::prefix('comment')->group(function () {
  Route::get('/', [CommentController::class, 'index']);
  Route::post('/', [CommentController::class, 'store']);
  Route::get('/{id}', [CommentController::class, 'show']);
  Route::put('/{id}', [CommentController::class, 'update']);
  Route::delete('/{id}', [CommentController::class, 'delete']);
});
