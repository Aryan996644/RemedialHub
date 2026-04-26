<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function adminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function teacherLoginForm()
    {
        return view('auth.teacher-login');
    }

    public function studentLoginForm()
    {
        return view('auth.student-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,teacher,student',
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->input('role');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== $role) {
                Auth::logout();
                return back()->with('error', 'Invalid credentials for this portal.');
            }

            if ($user->status === 'inactive') {
                Auth::logout();
                return back()->with('error', 'Your account has been deactivated. Contact admin.');
            }

            $request->session()->regenerate();

            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'teacher' => redirect()->route('teacher.dashboard'),
                'student' => redirect()->route('student.dashboard'),
                default => redirect('/'),
            };
        }

        return back()->with('error', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
