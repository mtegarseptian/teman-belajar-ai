<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $quizzes   = Quiz::withCount('questions')->get();
        $token     = $request->cookie('bio_session', '');
        $attempted = QuizAttempt::where('session_token', $token)
            ->pluck('quiz_id')
            ->toArray();

        return view('quiz.index', compact('quizzes', 'attempted'));
    }

    public function show(Quiz $quiz)
    {
        $questions = $quiz->questions()->get();
        return view('quiz.show', compact('quiz', 'questions'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate(['answers' => 'required|array']);

        $questions = $quiz->questions()->get();
        $answers   = $request->answers;
        $score     = 0;
        $token     = $request->cookie('bio_session', Str::uuid()->toString());

        foreach ($questions as $q) {
            if (isset($answers[$q->id]) && $answers[$q->id] === $q->correct_answer) {
                $score++;
            }
        }

        QuizAttempt::updateOrCreate(
            ['session_token' => $token, 'quiz_id' => $quiz->id],
            [
                'score'           => $score,
                'total_questions' => $questions->count(),
                'answers'         => $answers,
                'completed_at'    => now(),
            ]
        );

        return redirect()->route('quiz.result', $quiz->id);
    }

    public function result(Request $request, Quiz $quiz)
    {
        $token   = $request->cookie('bio_session', '');
        $attempt = QuizAttempt::where('session_token', $token)
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->firstOrFail();

        $questions = $quiz->questions()->get();

        return view('quiz.result', compact('quiz', 'attempt', 'questions'));
    }
}