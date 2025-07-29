<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScoreResource;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScoreController extends Controller
{
    /**
     * Display user's scores
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $level = $request->query('level');
        $perPage = $request->get('per_page', 10);

        $query = $user->scores()->latest();

        if ($level && in_array($level, ['mudah', 'sedang', 'sulit'])) {
            $query->byLevel($level);
        }

        $scores = $query->paginate($perPage);
        $allScores = $user->scores();
        if ($level && in_array($level, ['mudah', 'sedang', 'sulit'])) {
            $allScores->byLevel($level);
        }
        $allScoresData = $allScores->get();

        return response()->json([
            'success' => true,
            'message' => 'Scores retrieved successfully',
            'data' => [
                'total_scores' => $allScoresData->count(),
                'average_score' => round($allScoresData->avg('skor') ?? 0, 2),
                'best_score' => $allScoresData->max('skor') ?? 0,
                'scores' => ScoreResource::collection($scores->items())
            ],
            'pagination' => [
                'current_page' => $scores->currentPage(),
                'last_page' => $scores->lastPage(),
                'per_page' => $scores->perPage(),
                'total' => $scores->total(),
                'from' => $scores->firstItem(),
                'to' => $scores->lastItem()
            ]
        ]);
    }

    /**
     * Store a new score
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'skor' => 'required|numeric|min:0|max:100',
            'total_soal' => 'required|integer|min:1',
            'benar' => 'required|integer|min:0',
            'salah' => 'required|integer|min:0',
            'level' => 'required|in:mudah,sedang,sulit',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate that benar + salah = total_soal
        if ($request->benar + $request->salah !== $request->total_soal) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data: benar + salah must equal total_soal'
            ], 422);
        }

        $score = Score::create([
            'user_id' => $request->user()->id,
            'skor' => $request->skor,
            'total_soal' => $request->total_soal,
            'benar' => $request->benar,
            'salah' => $request->salah,
            'level' => $request->level,
            'tanggal' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Score saved successfully',
            'data' => new ScoreResource($score)
        ], 201);
    }

    /**
     * Display the specified score
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $score = $user->scores()->find($id);

        if (!$score) {
            return response()->json([
                'success' => false,
                'message' => 'Score not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Score retrieved successfully',
            'data' => new ScoreResource($score)
        ]);
    }

    /**
     * Get dashboard statistics
     */
    public function dashboardStats(Request $request)
    {
        $user = $request->user();
        $scores = $user->scores();

        // Overall statistics
        $totalQuizzes = $scores->count();
        $averageScore = $scores->avg('skor') ?? 0;
        $bestScore = $scores->max('skor') ?? 0;
        $totalCorrectAnswers = $scores->sum('benar');
        $totalQuestions = $scores->sum('total_soal');

        // Statistics by level
        $levelStats = [];
        foreach (['mudah', 'sedang', 'sulit'] as $level) {
            $levelScores = $user->scores()->byLevel($level);
            $levelStats[$level] = [
                'total_quizzes' => $levelScores->count(),
                'average_score' => round($levelScores->avg('skor') ?? 0, 2),
                'best_score' => $levelScores->max('skor') ?? 0,
                'total_correct' => $levelScores->sum('benar'),
                'total_questions' => $levelScores->sum('total_soal'),
                'accuracy' => $levelScores->sum('total_soal') > 0
                    ? round(($levelScores->sum('benar') / $levelScores->sum('total_soal')) * 100, 2)
                    : 0
            ];
        }

        // Recent scores (last 5)
        $recentScores = $user->scores()->latest()->take(5)->get();

        // Progress over time (last 10 scores)
        $progressData = $user->scores()->latest()->take(10)->get()->reverse()->values();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard statistics retrieved successfully',
            'data' => [
                'overall' => [
                    'total_quizzes' => $totalQuizzes,
                    'average_score' => round($averageScore, 2),
                    'best_score' => $bestScore,
                    'total_correct_answers' => $totalCorrectAnswers,
                    'total_questions' => $totalQuestions,
                    'overall_accuracy' => $totalQuestions > 0
                        ? round(($totalCorrectAnswers / $totalQuestions) * 100, 2)
                        : 0
                ],
                'by_level' => $levelStats,
                'recent_scores' => ScoreResource::collection($recentScores),
                'progress_chart' => $progressData->map(function ($score) {
                    return [
                        'date' => $score->tanggal->format('Y-m-d'),
                        'score' => $score->skor,
                        'level' => $score->level
                    ];
                })
            ]
        ]);
    }

    /**
     * Get leaderboard/ranking of users
     */
    public function leaderboard(Request $request)
    {
        $level = $request->query('level');
        $perPage = $request->get('per_page', 10);

        // Get users with their best scores
        $query = User::select('users.*')
            ->join('scores', 'users.id', '=', 'scores.user_id')
            ->selectRaw('MAX(scores.skor) as best_score')
            ->selectRaw('AVG(scores.skor) as avg_score')
            ->selectRaw('COUNT(scores.id) as total_quizzes')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.kelas', 'users.foto', 'users.role', 'users.created_at', 'users.updated_at', 'users.email_verified_at', 'users.password', 'users.remember_token');

        if ($level && in_array($level, ['mudah', 'sedang', 'sulit'])) {
            $query->where('scores.level', $level);
        }

        $leaderboard = $query->orderByDesc('best_score')
            ->orderByDesc('avg_score')
            ->paginate($perPage);

        $leaderboardData = $leaderboard->map(function ($user, $index) use ($leaderboard) {
            $rank = ($leaderboard->currentPage() - 1) * $leaderboard->perPage() + $index + 1;
            return [
                'rank' => $rank,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'kelas' => $user->kelas,
                    'foto' => $user->foto ? asset('storage/' . $user->foto) : null,
                ],
                'best_score' => round($user->best_score, 2),
                'avg_score' => round($user->avg_score, 2),
                'total_quizzes' => $user->total_quizzes
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Leaderboard retrieved successfully',
            'data' => $leaderboardData,
            'pagination' => [
                'current_page' => $leaderboard->currentPage(),
                'last_page' => $leaderboard->lastPage(),
                'per_page' => $leaderboard->perPage(),
                'total' => $leaderboard->total(),
                'from' => $leaderboard->firstItem(),
                'to' => $leaderboard->lastItem()
            ]
        ]);
    }

    /**
     * Get general app statistics
     */
    public function appStats(Request $request)
    {
        // Import models at the top if not already imported
        $totalUsers = User::count();
        $totalTools = \App\Models\Tool::count();
        $totalVideos = \App\Models\Video::count();
        $totalQuizzes = \App\Models\Quiz::count();
        $totalScores = Score::count();

        // Quiz statistics by level
        $quizByLevel = \App\Models\Quiz::selectRaw('level, COUNT(*) as count')
            ->groupBy('level')
            ->pluck('count', 'level')
            ->toArray();

        // Score statistics by level
        $scoresByLevel = Score::selectRaw('level, COUNT(*) as total_attempts, AVG(skor) as avg_score')
            ->groupBy('level')
            ->get()
            ->keyBy('level')
            ->toArray();

        // Recent activity (last 7 days)
        $recentScores = Score::where('created_at', '>=', now()->subDays(7))->count();
        $recentUsers = User::where('created_at', '>=', now()->subDays(7))->count();

        // Top performing users
        $topUsers = User::select('users.id', 'users.name', 'users.kelas')
            ->join('scores', 'users.id', '=', 'scores.user_id')
            ->selectRaw('AVG(scores.skor) as avg_score')
            ->selectRaw('COUNT(scores.id) as total_quizzes')
            ->groupBy('users.id', 'users.name', 'users.kelas')
            ->orderByDesc('avg_score')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'App statistics retrieved successfully',
            'data' => [
                'overview' => [
                    'total_users' => $totalUsers,
                    'total_tools' => $totalTools,
                    'total_videos' => $totalVideos,
                    'total_quizzes' => $totalQuizzes,
                    'total_quiz_attempts' => $totalScores
                ],
                'quiz_distribution' => [
                    'mudah' => $quizByLevel['mudah'] ?? 0,
                    'sedang' => $quizByLevel['sedang'] ?? 0,
                    'sulit' => $quizByLevel['sulit'] ?? 0
                ],
                'performance_by_level' => [
                    'mudah' => [
                        'total_attempts' => $scoresByLevel['mudah']['total_attempts'] ?? 0,
                        'avg_score' => round($scoresByLevel['mudah']['avg_score'] ?? 0, 2)
                    ],
                    'sedang' => [
                        'total_attempts' => $scoresByLevel['sedang']['total_attempts'] ?? 0,
                        'avg_score' => round($scoresByLevel['sedang']['avg_score'] ?? 0, 2)
                    ],
                    'sulit' => [
                        'total_attempts' => $scoresByLevel['sulit']['total_attempts'] ?? 0,
                        'avg_score' => round($scoresByLevel['sulit']['avg_score'] ?? 0, 2)
                    ]
                ],
                'recent_activity' => [
                    'new_users_last_7_days' => $recentUsers,
                    'quiz_attempts_last_7_days' => $recentScores
                ],
                'top_performers' => $topUsers->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'kelas' => $user->kelas,
                        'avg_score' => round($user->avg_score, 2),
                        'total_quizzes' => $user->total_quizzes
                    ];
                })
            ]
        ]);
    }
}
