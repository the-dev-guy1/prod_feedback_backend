<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

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



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/feedback', [FeedbackController::class, 'index']);
    Route::post('/feedback', [FeedbackController::class, 'store']);
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show']);
    Route::put('/feedback/{feedback}', [FeedbackController::class, 'update']);
    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy']);

    Route::get('/feedback/{feedback}/comments', [CommentController::class, 'index']);
    Route::post('/feedback/{feedback}/comments', [CommentController::class, 'store']);
    Route::get('/feedback/{feedback}/comments/{comment}', [CommentController::class, 'show']);
    Route::put('/feedback/{feedback}/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/feedback/{feedback}/comments/{comment}', [CommentController::class, 'destroy']);


    Route::get('/users', [UserController::class, 'index']);

});
