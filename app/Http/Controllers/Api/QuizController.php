<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    /**
     * Display a listing of quizzes by level
     */
    public function index(Request $request)
    {
        $level = $request->query('level', 'mudah');

        // Validate level
        if (!in_array($level, ['mudah', 'sedang', 'sulit'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid level. Must be: mudah, sedang, or sulit'
            ], 400);
        }

        $quizzes = Quiz::byLevel($level)->inRandomOrder()->get();

        return response()->json([
            'success' => true,
            'message' => 'Quizzes retrieved successfully',
            'data' => [
                'level' => $level,
                'total_soal' => $quizzes->count(),
                'quizzes' => QuizResource::collection($quizzes)
            ]
        ]);
    }

    /**
     * Submit quiz answers and calculate score
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level' => 'required|in:mudah,sedang,sulit',
            'answers' => 'required|array',
            'answers.*.quiz_id' => 'required|exists:quizzes,id',
            'answers.*.jawaban' => 'required|in:a,b,c,d',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $level = $request->level;
        $answers = $request->answers;
        $totalSoal = count($answers);
        $benar = 0;
        $salah = 0;
        $results = [];

        // Check each answer
        foreach ($answers as $answer) {
            $quiz = Quiz::find($answer['quiz_id']);
            $isCorrect = $quiz->jawaban_benar === $answer['jawaban'];

            if ($isCorrect) {
                $benar++;
            } else {
                $salah++;
            }

            $results[] = [
                'quiz_id' => $quiz->id,
                'soal' => $quiz->soal,
                'jawaban_user' => $answer['jawaban'],
                'jawaban_benar' => $quiz->jawaban_benar,
                'is_correct' => $isCorrect
            ];
        }

        // Calculate score (0-100)
        $skor = $totalSoal > 0 ? round(($benar / $totalSoal) * 100, 2) : 0;

        // Save score to database
        $score = Score::create([
            'user_id' => $request->user()->id,
            'skor' => $skor,
            'total_soal' => $totalSoal,
            'benar' => $benar,
            'salah' => $salah,
            'level' => $level,
            'tanggal' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quiz submitted successfully',
            'data' => [
                'score_id' => $score->id,
                'skor' => $skor,
                'total_soal' => $totalSoal,
                'benar' => $benar,
                'salah' => $salah,
                'level' => $level,
                'tanggal' => $score->tanggal->format('Y-m-d H:i:s'),
                'results' => $results
            ]
        ]);
    }
}
