<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use App\Models\QuizMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentQuizController extends Controller
{
    public function play(int $id)
    {
        $quiz = QuizMaster::where('status', 1)
            ->with(['questions' => fn ($q) => $q->with('options')])
            ->findOrFail($id);

        if ($quiz->questions->isEmpty()) {
            return redirect()->route('student.dashboard')->with('error', 'This quiz has no questions.');
        }

        return view('content.student.quiz-play', [
            'quiz' => $quiz,
            'memoryTime' => $quiz->memory_time ?? $quiz->quiz_time,
            'quizTime' => $quiz->quiz_time,
        ]);
    }

    public function submit(Request $request, int $id)
    {
        $quiz = QuizMaster::where('status', 1)->with('questions')->findOrFail($id);
        $student = Auth::guard('student')->user();

        $request->validate([
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|exists:quiz_question_options,id',
        ]);

        $attempt = new QuizAttempt();
        $attempt->student_id = $student->id;
        $attempt->quiz_master_id = $quiz->id;
        $attempt->started_at = now();
        $attempt->submitted_at = now();
        $attempt->save();

        $score = 0;
        $answers = $request->answers ?? [];
        foreach ($quiz->questions as $question) {
            $optionId = $answers[$question->id] ?? null;
            $isCorrect = $optionId && (int) $optionId === (int) $question->correct_option_id;
            if ($isCorrect) {
                $score++;
            }
            QuizAttemptAnswer::create([
                'quiz_attempt_id' => $attempt->id,
                'quiz_question_id' => $question->id,
                'quiz_question_option_id' => $optionId,
                'is_correct' => $isCorrect,
            ]);
        }

        $attempt->score = $score;
        $attempt->save();

        return redirect()->route('student.quiz.result', $attempt->id);
    }

    public function result(int $attempt)
    {
        $attempt = QuizAttempt::with(['quizMaster', 'answers.quizQuestion', 'answers.selectedOption'])
            ->where('student_id', Auth::guard('student')->id())
            ->findOrFail($attempt);

        $total = $attempt->quizMaster->questions->count();
        $score = $attempt->score ?? 0;

        return view('content.student.quiz-result', [
            'attempt' => $attempt,
            'score' => $score,
            'total' => $total,
        ]);
    }
}
