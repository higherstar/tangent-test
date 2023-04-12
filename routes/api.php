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
  Route::get('/', [UserController::class, 'index'])->middleware('log.route');;
  Route::post('/', [UserController::class, 'store'])->middleware('log.route');;
  Route::get('/{id}', [UserController::class, 'show'])->middleware('log.route');;
  Route::put('/{id}', [UserController::class, 'update'])->middleware('log.route');;
  Route::delete('/{id}', [UserController::class, 'delete'])->middleware('log.route');;
});

Route::prefix('category')->group(function () {
  Route::get('/', [CategoryController::class, 'index'])->middleware('log.route');;
  Route::post('/', [CategoryController::class, 'store'])->middleware('log.route');;
  Route::get('/{id}', [CategoryController::class, 'show'])->middleware('log.route');;
  Route::put('/{id}', [CategoryController::class, 'update'])->middleware('log.route');;
  Route::delete('/{id}', [CategoryController::class, 'delete'])->middleware('log.route');;
});

Route::prefix('post')->group(function () {
  Route::get('/', [PostController::class, 'index'])->middleware('log.route');;
  Route::post('/', [PostController::class, 'store'])->middleware('log.route');;
  Route::get('/{id}', [PostController::class, 'show'])->middleware('log.route');;
  Route::put('/{id}', [PostController::class, 'update'])->middleware('log.route');;
  Route::delete('/{id}', [PostController::class, 'delete'])->middleware('log.route');;
});

Route::prefix('comment')->group(function () {
  Route::get('/', [CommentController::class, 'index'])->middleware('log.route');;
  Route::post('/', [CommentController::class, 'store'])->middleware('log.route');;
  Route::get('/{id}', [CommentController::class, 'show'])->middleware('log.route');;
  Route::put('/{id}', [CommentController::class, 'update'])->middleware('log.route');;
  Route::delete('/{id}', [CommentController::class, 'delete'])->middleware('log.route');;
});
