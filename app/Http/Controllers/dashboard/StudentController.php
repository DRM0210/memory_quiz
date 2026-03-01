<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $data = Student::orderBy('id', 'desc')->get();
        return view('content.dashboard.students.index', compact('data'));
    }

    public function status(Request $request)
    {
        $data = Student::findOrFail($request->id);
        $data->status = $data->status == 1 ? 0 : 1;
        $data->save();
        return response()->json(['success' => true]);
    }
}
