<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitQuizRequest;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    /**
     * Get quizzes by level
     */
    public function getQuizzesByLevel(Request $request, $level)
    {
        try {
            $validLevels = ['mudah', 'sedang', 'sulit'];

            if (!in_array($level, $validLevels)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid level. Must be mudah, sedang, or sulit'
                ], 400);
            }

            $limit = $request->get('limit', 5);

            $quizzes = Quiz::where('level', $level)
                ->inRandomOrder()
                ->limit($limit)
                ->get([
                    'id',
                    'soal',
                    'pilihan_a',
                    'pilihan_b',
                    'pilihan_c',
                    'pilihan_d',
                    'level'
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Quizzes retrieved successfully',
                'data' => [
                    'level' => $level,
                    'total_questions' => $quizzes->count(),
                    'quizzes' => $quizzes
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve quizzes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit quiz answers and calculate score
     */
    public function submitQuiz(SubmitQuizRequest $request)
    {
        try {
            $user = Auth::user();
            $answers = $request->answers;
            $level = $request->level;

            $totalQuestions = count($answers);
            $correctAnswers = 0;
            $incorrectAnswers = 0;
            $results = [];

            // Calculate score
            foreach ($answers as $answer) {
                $quiz = Quiz::find($answer['quiz_id']);
                $isCorrect = $quiz && $quiz->jawaban_benar === $answer['jawaban'];

                if ($isCorrect) {
                    $correctAnswers++;
                } else {
                    $incorrectAnswers++;
                }

                $results[] = [
                    'quiz_id' => $quiz->id,
                    'soal' => $quiz->soal,
                    'jawaban_user' => $answer['jawaban'],
                    'jawaban_benar' => $quiz->jawaban_benar,
                    'is_correct' => $isCorrect
                ];
            }

            // Calculate percentage score
            $scorePercentage = ($correctAnswers / $totalQuestions) * 100;

            // Save score to database
            $score = Score::create([
                'user_id' => $user->id,
                'skor' => round($scorePercentage, 2),
                'total_soal' => $totalQuestions,
                'benar' => $correctAnswers,
                'salah' => $incorrectAnswers,
                'level' => $level,
                'tanggal' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kuis disubmit dengan sukses',
                'data' => [
                    'score_id' => $score->id,
                    'score_percentage' => $scorePercentage,
                    'correct_answers' => $correctAnswers,
                    'incorrect_answers' => $incorrectAnswers,
                    'total_questions' => $totalQuestions,
                    'level' => $level,
                    'grade' => $this->getGrade($scorePercentage),
                    'results' => $results
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit quiz',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's quiz history
     */
    public function getQuizHistory(Request $request)
    {
        try {
            $user = Auth::user();
            $perPage = $request->get('per_page', 10);
            $level = $request->get('level');

            $query = Score::where('user_id', $user->id)
                ->orderBy('created_at', 'desc');

            if ($level) {
                $query->where('level', $level);
            }

            $scores = $query->paginate($perPage);

            $formattedScores = $scores->getCollection()->map(function ($score) {
                return [
                    'id' => $score->id,
                    'score' => $score->skor,
                    'correct_answers' => $score->benar,
                    'incorrect_answers' => $score->salah,
                    'total_questions' => $score->total_soal,
                    'level' => $score->level,
                    'grade' => $this->getGrade($score->skor),
                    'date' => $score->tanggal,
                    'created_at' => $score->created_at->format('Y-m-d H:i:s')
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Quiz history retrieved successfully',
                'data' => $formattedScores,
                'pagination' => [
                    'current_page' => $scores->currentPage(),
                    'last_page' => $scores->lastPage(),
                    'per_page' => $scores->perPage(),
                    'total' => $scores->total()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve quiz history',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get quiz statistics for user
     */
    public function getQuizStats(Request $request)
    {
        try {
            $user = Auth::user();

            $stats = [
                'total_quizzes_taken' => Score::where('user_id', $user->id)->count(),
                'average_score' => Score::where('user_id', $user->id)->avg('skor') ?? 0,
                'best_score' => Score::where('user_id', $user->id)->max('skor') ?? 0,
                'by_level' => []
            ];

            // Get stats by level
            $levels = ['mudah', 'sedang', 'sulit'];
            foreach ($levels as $level) {
                $levelScores = Score::where('user_id', $user->id)
                    ->where('level', $level);

                $stats['by_level'][$level] = [
                    'total_taken' => $levelScores->count(),
                    'average_score' => $levelScores->avg('skor') ?? 0,
                    'best_score' => $levelScores->max('skor') ?? 0,
                    'total_correct' => $levelScores->sum('benar'),
                    'total_questions' => $levelScores->sum('total_soal')
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Quiz statistics retrieved successfully',
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve quiz statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get grade based on score percentage
     */
    private function getGrade($scorePercentage)
    {
        if ($scorePercentage >= 90) {
            return 'A';
        } elseif ($scorePercentage >= 80) {
            return 'B';
        } elseif ($scorePercentage >= 70) {
            return 'C';
        } elseif ($scorePercentage >= 60) {
            return 'D';
        } else {
            return 'E';
        }
    }
}
