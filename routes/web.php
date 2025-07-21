<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ToolController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\ScoreController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Admin Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Tool Management
    Route::resource('tools', ToolController::class);

    // Video Management
    Route::resource('videos', VideoController::class);

    // Quiz Management
    Route::resource('quizzes', QuizController::class);

    // Score Management
    Route::get('scores', [ScoreController::class, 'index'])->name('scores.index');
    Route::get('scores/statistics', [ScoreController::class, 'statistics'])->name('scores.statistics');
    Route::get('scores/{score}', [ScoreController::class, 'show'])->name('scores.show');
    Route::delete('scores/{score}', [ScoreController::class, 'destroy'])->name('scores.destroy');
});
