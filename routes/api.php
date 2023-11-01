<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function Laravel\Prompts\search;

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

Route::middleware('auth:sanctum')->group(function() {
	Route::get('/user', function (Request $request) {
		return $request->user();
	});


	// Route::get('/feedbacks/subject', [FeedbackController::class, 'subject'])->name('feedbacks.subject');
	Route::post('/logout', [AuthController::class, 'logout']);
	Route::apiResource('/users', UserController::class);
	Route::apiResource('/feedbacks', FeedbackController::class);
});


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
