<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::post('/user/login', [AuthController::class, 'login']);
Route::post('/user/register', [AuthController::class, 'register']);
Route::post('/user', [AuthController::class, 'getUser'])->middleware('auth:api');
Route::post('/post', [PostController::class, 'create'])->middleware('auth:api');
Route::get('/post', [PostController::class, 'getPosts'])->middleware('auth:api');
Route::post('/post/like', [PostController::class, 'likePost'])->middleware('auth:api');
Route::post('/user/logout', [AuthController::class, 'logout']);
Route::get('/user', [UserController::class, 'search'])->middleware('auth:api');
Route::get('/user/account/{id}', [UserController::class, 'getSelectedUser'])->middleware('auth:api');
Route::post('/user/add', [UserController::class, 'addFriend'])->middleware('auth:api');
Route::post('/user/accept', [UserController::class, 'acceptFriend'])->middleware('auth:api');
Route::get('/user/friends', [UserController::class, 'getFriendList'])->middleware('auth:api');
Route::post('/post/comment', [PostController::class, 'commentPost'])->middleware('auth:api');
Route::post('/post/delete', [PostController::class, 'deletePost'])->middleware('auth:api');
Route::post('/post/update', [PostController::class, 'updatePost'])->middleware('auth:api');
Route::post('/user/remove', [UserController::class, 'removeFriend'])->middleware('auth:api');
