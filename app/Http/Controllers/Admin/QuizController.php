<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of quizzes
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $level = $request->get('level');
        $sort = $request->get('sort', 'newest');
        $grouped = $request->get('grouped');

        $query = Quiz::query();

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('soal', 'like', '%' . $search . '%')
                  ->orWhere('pilihan_a', 'like', '%' . $search . '%')
                  ->orWhere('pilihan_b', 'like', '%' . $search . '%')
                  ->orWhere('pilihan_c', 'like', '%' . $search . '%')
                  ->orWhere('pilihan_d', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan level
        if ($level && in_array($level, ['mudah', 'sedang', 'sulit'])) {
            $query->where('level', $level);
        }

        // Jika grouped view, ambil data berdasarkan level
        if ($grouped) {
            $quizzesGrouped = [
                'mudah' => (clone $query)->where('level', 'mudah')->latest()->get(),
                'sedang' => (clone $query)->where('level', 'sedang')->latest()->get(),
                'sulit' => (clone $query)->where('level', 'sulit')->latest()->get(),
            ];
            $quizzes = null;
        } else {
            // Sorting untuk list view
            switch ($sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'level_asc':
                    $query->orderByRaw("FIELD(level, 'mudah', 'sedang', 'sulit')");
                    break;
                case 'level_desc':
                    $query->orderByRaw("FIELD(level, 'sulit', 'sedang', 'mudah')");
                    break;
                default: // newest
                    $query->latest();
                    break;
            }
            $quizzes = $query->paginate(10)->appends(request()->query());
            $quizzesGrouped = null;
        }

        // Statistik level
        $stats = [
            'mudah' => Quiz::where('level', 'mudah')->count(),
            'sedang' => Quiz::where('level', 'sedang')->count(),
            'sulit' => Quiz::where('level', 'sulit')->count(),
        ];

        return view('admin.quizzes.index', compact('quizzes', 'quizzesGrouped', 'level', 'search', 'sort', 'stats', 'grouped'));
    }

    /**
     * Show the form for creating a new quiz
     */
    public function create()
    {
        return view('admin.quizzes.create');
    }

    /**
     * Store a newly created quiz
     */
    public function store(Request $request)
    {
        $request->validate([
            'soal' => 'required|string',
            'pilihan_a' => 'required|string|max:255',
            'pilihan_b' => 'required|string|max:255',
            'pilihan_c' => 'required|string|max:255',
            'pilihan_d' => 'required|string|max:255',
            'jawaban_benar' => 'required|in:a,b,c,d',
            'level' => 'required|in:mudah,sedang,sulit',
        ]);

        Quiz::create($request->all());

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz berhasil ditambahkan.');
    }

    /**
     * Display the specified quiz
     */
    public function show(Quiz $quiz)
    {
        return view('admin.quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz
     */
    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified quiz
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'soal' => 'required|string',
            'pilihan_a' => 'required|string|max:255',
            'pilihan_b' => 'required|string|max:255',
            'pilihan_c' => 'required|string|max:255',
            'pilihan_d' => 'required|string|max:255',
            'jawaban_benar' => 'required|in:a,b,c,d',
            'level' => 'required|in:mudah,sedang,sulit',
        ]);

        $quiz->update($request->all());

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz berhasil diupdate.');
    }

    /**
     * Remove the specified quiz
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz berhasil dihapus.');
    }
}
