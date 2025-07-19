<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ToolController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\ScoreController;

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

// Public routes (no authentication required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);
    
    // Tools routes
    Route::apiResource('tools', ToolController::class);
    
    // Videos routes
    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/videos/{id}', [VideoController::class, 'show']);
    
    // Quiz routes
    Route::get('/quizzes', [QuizController::class, 'index']); // ?level=mudah|sedang|sulit
    Route::post('/quizzes/submit', [QuizController::class, 'submit']);
    
    // Score routes
    Route::get('/scores', [ScoreController::class, 'index']); // ?level=mudah|sedang|sulit
    Route::post('/scores', [ScoreController::class, 'store']);
    Route::get('/scores/{id}', [ScoreController::class, 'show']);
    
    // Dashboard statistics
    Route::get('/dashboard/stats', [ScoreController::class, 'dashboardStats']);
    Route::get('/leaderboard', [ScoreController::class, 'leaderboard']);
    Route::get('/app/stats', [ScoreController::class, 'appStats']);
});
