<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\QuizType;
use Illuminate\Http\Request;

class QuizTypeController extends Controller
{
    public function index()
    {
        $data = QuizType::orderBy('id', 'desc')->get();
        return view('content.dashboard.quiz-type.index', compact('data'));
    }

    public function create()
    {
        return view('content.dashboard.quiz-type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_duration' => 'required|integer|min:0',
            'no_of_questions' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $uploadPath = public_path('assets/uploads/quiz-type');
        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0755, true);
        }

        $data = new QuizType();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->time_duration = $request->time_duration;
        $data->no_of_questions = $request->no_of_questions;
        $data->status = 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'quiz-type-' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data->image = 'assets/uploads/quiz-type/' . $filename;
        }

        $data->save();
        session()->flash('success', 'Quiz Type created successfully.');
        return redirect()->route('quiz-type.index');
    }

    public function edit($id)
    {
        $data = QuizType::findOrFail($id);
        return view('content.dashboard.quiz-type.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_duration' => 'required|integer|min:0',
            'no_of_questions' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = QuizType::findOrFail($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->time_duration = $request->time_duration;
        $data->no_of_questions = $request->no_of_questions;

        $uploadPath = public_path('assets/uploads/quiz-type');
        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0755, true);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'quiz-type-' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data->image = 'assets/uploads/quiz-type/' . $filename;
        }

        $data->save();
        session()->flash('success', 'Quiz Type updated successfully.');
        return redirect()->route('quiz-type.index');
    }

    public function status(Request $request)
    {
        $data = QuizType::findOrFail($request->id);
        $data->status = $request->state == 1 ? 0 : 1;
        $data->save();
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        QuizType::findOrFail($request->id)->delete();
        return response()->json(['success' => true]);
    }
}
