<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ToolController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\ScoreController;
use App\Http\Controllers\Api\CategoryController;


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

// Categories routes (read-only, public access)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// Tools routes (read-only, public access)
Route::get('/tools', [ToolController::class, 'index']);
Route::get('/tools/{id}', [ToolController::class, 'show']);

// Videos routes (public access)
Route::get('/videos', [VideoController::class, 'index']);
Route::get('/videos/{id}', [VideoController::class, 'show']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);

    // Quiz routes
    Route::get('/quizzes/{level}', [QuizController::class, 'getQuizzesByLevel']);
    Route::post('/quizzes/submit', [QuizController::class, 'submitQuiz']);
    Route::get('/quizzes/history/user', [QuizController::class, 'getQuizHistory']);
    Route::get('/quizzes/stats/user', [QuizController::class, 'getQuizStats']);

    // Score routes
    Route::get('/scores', [ScoreController::class, 'index']);
    Route::post('/scores', [ScoreController::class, 'store']);
    Route::get('/scores/{id}', [ScoreController::class, 'show']);

    // Dashboard statistics
    Route::get('/dashboard/stats', [ScoreController::class, 'dashboardStats']);
    Route::get('/leaderboard', [ScoreController::class, 'leaderboard']);
    Route::get('/app/stats', [ScoreController::class, 'appStats']);
});
