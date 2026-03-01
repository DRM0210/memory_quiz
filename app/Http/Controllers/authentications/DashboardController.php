<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\QuizMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        Auth::user();
        $availableQuizzes = QuizMaster::where('status', 1)
            ->with('quizType')
            ->withCount('questions')
            ->orderBy('name')
            ->get();
        return view('content.dashboard.dashboards-analytics', compact('availableQuizzes'));
    }

    



}
