<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of scores
     */
    public function index(Request $request)
    {
        $level = $request->get('level');
        $user_id = $request->get('user_id');

        $query = Score::with('user');

        if ($level && in_array($level, ['mudah', 'sedang', 'sulit'])) {
            $query->where('level', $level);
        }

        if ($user_id) {
            $query->where('user_id', $user_id);
        }

        $scores = $query->latest()->paginate(15);
        $users = User::orderBy('name')->get();

        return view('admin.scores.index', compact('scores', 'level', 'user_id', 'users'));
    }

    /**
     * Display the specified score
     */
    public function show(Score $score)
    {
        $score->load('user');
        return view('admin.scores.show', compact('score'));
    }

    /**
     * Remove the specified score
     */
    public function destroy(Score $score)
    {
        $score->delete();

        return redirect()->route('admin.scores.index')
            ->with('success', 'Score berhasil dihapus.');
    }

    /**
     * Display statistics
     */
    public function statistics()
    {
        $statistics = [
            'total_attempts' => Score::count(),
            'average_score' => Score::avg('skor') ?? 0,
            'highest_score' => Score::max('skor') ?? 0,
            'active_students' => User::whereHas('scores')->count(),
            'by_level' => [
                'mudah' => [
                    'total' => Score::where('level', 'mudah')->count(),
                    'average' => Score::where('level', 'mudah')->avg('skor') ?? 0,
                ],
                'sedang' => [
                    'total' => Score::where('level', 'sedang')->count(),
                    'average' => Score::where('level', 'sedang')->avg('skor') ?? 0,
                ],
                'sulit' => [
                    'total' => Score::where('level', 'sulit')->count(),
                    'average' => Score::where('level', 'sulit')->avg('skor') ?? 0,
                ],
            ],
            'score_distribution' => [
                'excellent' => Score::where('skor', '>=', 80)->count(),
                'good' => Score::whereBetween('skor', [70, 79])->count(),
                'fair' => Score::whereBetween('skor', [60, 69])->count(),
                'poor' => Score::where('skor', '<', 60)->count(),
            ],
            'top_students' => User::selectRaw('users.*, AVG(scores.skor) as average_score, COUNT(scores.id) as total_attempts')
                ->join('scores', 'users.id', '=', 'scores.user_id')
                ->groupBy('users.id')
                ->orderByDesc('average_score')
                ->take(10)
                ->get(),
            'recent_scores' => Score::with('user')
                ->latest()
                ->take(10)
                ->get(),
        ];

        return view('admin.scores.statistics', compact('statistics'));
    }
}
