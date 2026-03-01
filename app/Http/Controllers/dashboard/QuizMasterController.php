<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\QuizMaster;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;
use App\Models\QuizType;
use Illuminate\Http\Request;

class QuizMasterController extends Controller
{
    public function index()
    {
        $data = QuizMaster::with('quizType')->orderBy('id', 'desc')->get();
        return view('content.dashboard.quiz-master.index', compact('data'));
    }

    public function create()
    {
        $quizTypes = QuizType::where('status', 1)->orderBy('name')->get();
        return view('content.dashboard.quiz-master.create', compact('quizTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quiz_type_id' => 'required|exists:quiz_types,id',
            'name' => 'required|string|max:255',
            'memory_page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'quiz_time' => 'required|integer|min:0',
            'status' => 'nullable|in:0,1',
        ]);

        $uploadPath = public_path('assets/uploads/quiz-master');
        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0755, true);
        }

        $data = new QuizMaster();
        $data->quiz_type_id = $request->quiz_type_id;
        $data->name = $request->name;
        $data->quiz_time = $request->quiz_time ?? 0;
        $data->status = $request->has('status') ? (int) $request->status : 1;

        if ($request->hasFile('memory_page_image')) {
            $file = $request->file('memory_page_image');
            $filename = 'memory-page-' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data->memory_page_image = 'assets/uploads/quiz-master/' . $filename;
        }

        $data->save();
        session()->flash('success', 'Quiz Master created successfully.');
        return redirect()->route('quiz-master.index');
    }

    public function edit($id)
    {
        $data = QuizMaster::with('quizType')->findOrFail($id);
        $quizTypes = QuizType::where('status', 1)->orderBy('name')->get();
        return view('content.dashboard.quiz-master.edit', compact('data', 'quizTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quiz_type_id' => 'required|exists:quiz_types,id',
            'name' => 'required|string|max:255',
            'memory_page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'quiz_time' => 'required|integer|min:0',
            'status' => 'nullable|in:0,1',
        ]);

        $data = QuizMaster::findOrFail($id);
        $data->quiz_type_id = $request->quiz_type_id;
        $data->name = $request->name;
        $data->quiz_time = $request->quiz_time ?? 0;
        $data->status = $request->has('status') ? (int) $request->status : 1;

        $uploadPath = public_path('assets/uploads/quiz-master');
        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0755, true);
        }
        if ($request->hasFile('memory_page_image')) {
            $file = $request->file('memory_page_image');
            $filename = 'memory-page-' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data->memory_page_image = 'assets/uploads/quiz-master/' . $filename;
        }

        $data->save();
        session()->flash('success', 'Quiz Master updated successfully.');
        return redirect()->route('quiz-master.index');
    }

    public function status(Request $request)
    {
        $data = QuizMaster::findOrFail($request->id);
        $data->status = $request->state == 1 ? 0 : 1;
        $data->save();
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        QuizMaster::findOrFail($request->id)->delete();
        return response()->json(['success' => true]);
    }

    // --- Questions (for a quiz master) ---

    public function questions($id)
    {
        $quizMaster = QuizMaster::with(['questions.options', 'quizType'])->findOrFail($id);
        return view('content.dashboard.quiz-master.questions', compact('quizMaster'));
    }

    public function questionCreate($id)
    {
        $quizMaster = QuizMaster::findOrFail($id);
        return view('content.dashboard.quiz-master.question-form', compact('quizMaster'));
    }

    public function questionStore(Request $request, $id)
    {
        $quizMaster = QuizMaster::findOrFail($id);
        $request->validate([
            'question_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'answer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'correct_option_id' => 'nullable|integer',
            'options' => 'required|array|min:2',
        ], [
            'options.required' => 'Add at least 2 answer options.',
        ]);

        $validOptions = 0;
        foreach ($request->options as $opt) {
            if (isset($opt['image']) && $opt['image'] && $opt['image']->isValid()) {
                $validOptions++;
            }
        }
        if ($validOptions < 2) {
            return redirect()->back()->withInput()->withErrors(['options' => 'At least 2 options must have an image.']);
        }

        $uploadPathQ = public_path('assets/uploads/quiz-questions');
        $uploadPathO = public_path('assets/uploads/quiz-options');
        foreach ([$uploadPathQ, $uploadPathO] as $p) {
            if (!is_dir($p)) {
                @mkdir($p, 0755, true);
            }
        }

        $maxOrder = $quizMaster->questions()->max('sort_order') ?? 0;

        $question = new QuizQuestion();
        $question->quiz_master_id = $quizMaster->id;
        $question->sort_order = $maxOrder + 1;

        if ($request->hasFile('question_image')) {
            $file = $request->file('question_image');
            $filename = 'q-' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPathQ, $filename);
            $question->question_image = 'assets/uploads/quiz-questions/' . $filename;
        }
        if ($request->hasFile('answer_image')) {
            $file = $request->file('answer_image');
            $filename = 'a-' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPathQ, $filename);
            $question->answer_image = 'assets/uploads/quiz-questions/' . $filename;
        }

        $question->save();

        $labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        $correctId = null;
        foreach ($request->options as $idx => $opt) {
            if (!isset($opt['image']) || !$opt['image']->isValid()) {
                continue;
            }
            $filename = 'opt-' . $question->id . '-' . $idx . '-' . time() . '.' . $opt['image']->getClientOriginalExtension();
            $opt['image']->move($uploadPathO, $filename);
            $option = new QuizQuestionOption();
            $option->quiz_question_id = $question->id;
            $option->image = 'assets/uploads/quiz-options/' . $filename;
            $option->label = $labels[$idx] ?? ($idx + 1);
            $option->sort_order = $idx;
            $option->save();
            if ((int) $request->correct_option_index === $idx) {
                $correctId = $option->id;
            }
        }
        if ($correctId) {
            $question->correct_option_id = $correctId;
            $question->save();
        }

        session()->flash('success', 'Question added successfully.');
        return redirect()->route('quiz-master.questions', $quizMaster->id);
    }

    public function questionEdit($masterId, $questionId)
    {
        $quizMaster = QuizMaster::findOrFail($masterId);
        $question = QuizQuestion::with('options')->where('quiz_master_id', $masterId)->findOrFail($questionId);
        return view('content.dashboard.quiz-master.question-form', compact('quizMaster', 'question'));
    }

    public function questionUpdate(Request $request, $masterId, $questionId)
    {
        $quizMaster = QuizMaster::findOrFail($masterId);
        $question = QuizQuestion::with('options')->where('quiz_master_id', $masterId)->findOrFail($questionId);

        $request->validate([
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'answer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options' => 'required|array|min:2',
        ], [
            'options.required' => 'Keep at least 2 answer options.',
        ]);

        $uploadPathQ = public_path('assets/uploads/quiz-questions');
        $uploadPathO = public_path('assets/uploads/quiz-options');
        if (!is_dir($uploadPathO)) {
            @mkdir($uploadPathO, 0755, true);
        }
        if (!is_dir($uploadPathQ)) {
            @mkdir($uploadPathQ, 0755, true);
        }

        if ($request->hasFile('question_image')) {
            $file = $request->file('question_image');
            $filename = 'q-' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPathQ, $filename);
            $question->question_image = 'assets/uploads/quiz-questions/' . $filename;
        }
        if ($request->hasFile('answer_image')) {
            $file = $request->file('answer_image');
            $filename = 'a-' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPathQ, $filename);
            $question->answer_image = 'assets/uploads/quiz-questions/' . $filename;
        }

        $question->save();

        $labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        $keepIds = [];

        foreach ($request->options as $idx => $opt) {
            $optionId = isset($opt['id']) ? (int) $opt['id'] : null;
            $option = $optionId ? QuizQuestionOption::where('quiz_question_id', $question->id)->find($optionId) : null;

            if ($option) {
                $keepIds[] = $option->id;
                if (isset($opt['image']) && $opt['image'] && $opt['image']->isValid()) {
                    $filename = 'opt-' . $question->id . '-' . $idx . '-' . time() . '.' . $opt['image']->getClientOriginalExtension();
                    $opt['image']->move($uploadPathO, $filename);
                    $option->image = 'assets/uploads/quiz-options/' . $filename;
                }
                $option->label = $labels[$idx] ?? ($idx + 1);
                $option->sort_order = $idx;
                $option->save();
                if ($request->correct_option_index !== null && (int) $request->correct_option_index === $idx) {
                    $question->correct_option_id = $option->id;
                    $question->save();
                }
            } else {
                if (!isset($opt['image']) || !$opt['image'] || !$opt['image']->isValid()) {
                    continue;
                }
                $filename = 'opt-' . $question->id . '-' . $idx . '-' . time() . '.' . $opt['image']->getClientOriginalExtension();
                $opt['image']->move($uploadPathO, $filename);
                $newOpt = new QuizQuestionOption();
                $newOpt->quiz_question_id = $question->id;
                $newOpt->image = 'assets/uploads/quiz-options/' . $filename;
                $newOpt->label = $labels[$idx] ?? ($idx + 1);
                $newOpt->sort_order = $idx;
                $newOpt->save();
                $keepIds[] = $newOpt->id;
                if ($request->correct_option_index !== null && (int) $request->correct_option_index === $idx) {
                    $question->correct_option_id = $newOpt->id;
                    $question->save();
                }
            }
        }

        QuizQuestionOption::where('quiz_question_id', $question->id)->whereNotIn('id', $keepIds)->delete();
        if ($question->correct_option_id && !in_array($question->correct_option_id, $keepIds)) {
            $question->correct_option_id = null;
            $question->save();
        }

        session()->flash('success', 'Question updated successfully.');
        return redirect()->route('quiz-master.questions', $quizMaster->id);
    }

    public function questionDestroy(Request $request)
    {
        $question = QuizQuestion::findOrFail($request->id);
        $masterId = $question->quiz_master_id;
        $question->delete();
        return response()->json(['success' => true, 'redirect' => route('quiz-master.questions', $masterId)]);
    }
}
