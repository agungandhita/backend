<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tool;
use App\Models\Video;
use App\Models\Quiz;
use App\Models\Score;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung rata-rata skor
        $averageScore = Score::avg('skor') ?? 0;

        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'siswa')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_categories' => Category::count(),
            'total_tools' => Tool::count(),
            'active_tools' => Tool::where('is_active', true)->count(),
            'featured_tools' => Tool::where('is_featured', true)->count(),
            'total_videos' => Video::count(),
            'total_quizzes' => Quiz::count(),
            'total_scores' => Score::count(),
            'recent_scores' => Score::with('user')->latest()->take(5)->get(),
            'recent_tools' => Tool::latest()->take(5)->get(),
            'active_students' => User::where('role', 'siswa')->whereHas('scores', function($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })->count(),
            'monthly_video_views' => Score::where('created_at', '>=', now()->subMonth())->count(),
            'average_score' => $averageScore,
            'quiz_by_level' => [
                'mudah' => Quiz::where('level', 'mudah')->count(),
                'sedang' => Quiz::where('level', 'sedang')->count(),
                'sulit' => Quiz::where('level', 'sulit')->count(),
            ]
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}
