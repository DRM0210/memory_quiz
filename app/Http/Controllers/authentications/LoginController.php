<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function loginForm() {
    if(auth()->check()){
        return redirect()->route('dashboard');
      }
      $company = CompanyInfo::first();
      return view('content.authentications.login', compact('company'));
  }


    public function qwerty(){
        if(auth()->check()){
            return redirect()->route('dashboard');
        }
        $company = CompanyInfo::first();
        return view('content.authentications.login', compact('company'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->route('dashboard');
        }

        // Authentication failed
        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect()->route('loginForm');
    }
}
