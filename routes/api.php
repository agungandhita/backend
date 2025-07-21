<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ToolController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\ScoreController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;

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

    // Categories routes
    Route::apiResource('categories', CategoryController::class);
    
    // Tools routes
    Route::apiResource('tools', ToolController::class);
    Route::get('/tools/featured/list', [ToolController::class, 'featured']);
    Route::get('/tools/popular/list', [ToolController::class, 'popular']);
    Route::post('/tools/{id}/favorite', [ToolController::class, 'toggleFavorite']);
    
    // Favorites routes
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{tool_id}', [FavoriteController::class, 'destroy']);
    Route::get('/favorites/{tool_id}/check', [FavoriteController::class, 'check']);

    // Videos routes
    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/videos/{id}', [VideoController::class, 'show']);

    // Quiz routes
    Route::get('/quizzes/{level}', [QuizController::class, 'getQuizzesByLevel']); // level: easy|medium|hard
    Route::post('/quizzes/submit', [QuizController::class, 'submitQuiz']);
    Route::get('/quizzes/history/user', [QuizController::class, 'getQuizHistory']);
    Route::get('/quizzes/stats/user', [QuizController::class, 'getQuizStats']);

    // Score routes
    Route::get('/scores', [ScoreController::class, 'index']); // ?level=mudah|sedang|sulit
    Route::post('/scores', [ScoreController::class, 'store']);
    Route::get('/scores/{id}', [ScoreController::class, 'show']);

    // Dashboard statistics
    Route::get('/dashboard/stats', [ScoreController::class, 'dashboardStats']);
    Route::get('/leaderboard', [ScoreController::class, 'leaderboard']);
    Route::get('/app/stats', [ScoreController::class, 'appStats']);
});
