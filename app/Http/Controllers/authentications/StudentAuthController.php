<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function signupForm()
    {
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }
        $company = CompanyInfo::first();
        return view('content.student.signup', compact('company'));
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:50|unique:students,phone',
            'address' => 'nullable|string|max:500',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.confirmed' => 'Password and confirm password do not match.',
        ]);

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => $request->password,
            'status' => 0,
        ]);

        session()->flash('success', 'Registration successful. Please login after admin activates your account.');
        return redirect()->route('student.login');
    }

    public function loginForm()
    {
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }
        $company = CompanyInfo::first();
        return view('content.student.login', compact('company'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $login = $request->login;
        $password = $request->password;

        $student = Student::where('email', $login)->orWhere('phone', $login)->first();

        if (!$student || !Hash::check($password, $student->password)) {
            return redirect()->back()->withErrors(['login' => 'Invalid email/phone or password.']);
        }

        if ($student->status != 1) {
            return redirect()->back()->withErrors(['login' => 'Your account is inactive. Please contact admin.']);
        }

        Auth::guard('student')->login($student, $request->boolean('remember'));
        $request->session()->regenerate();
        return redirect()->intended(route('student.dashboard'));
    }

    public function dashboard()
    {
        $student = Auth::guard('student')->user();
        $availableQuizzes = \App\Models\QuizMaster::where('status', 1)
            ->withCount('questions')
            ->orderBy('name')
            ->get();
        return view('content.student.dashboard', compact('student', 'availableQuizzes'));
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.login');
    }
}
