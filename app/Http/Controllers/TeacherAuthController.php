<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class TeacherAuthController extends Controller
{
    public function showRegisterForm() {
        return view('auth.teacher_register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:teachers',
            'password' => 'required|min:6|confirmed',
        ]);

        Teacher::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('teacher.login.form')->with('success', 'Registration successful');
    }

    public function showLoginForm() {
        return view('auth.teacher_login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
         if (Auth::guard('teacher')->attempt($credentials)) {
       
        $teacher = Auth::guard('teacher')->user();
        Session::put('teacher_id', $teacher->id);

       
        return redirect()->route('teacher.dashboard')->with('success', 'Login successful! Welcome, ' . $teacher->name);
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
    }

 public function sessionget(){

         $teacherId = Session::get('teacher_id');
//dd(Session::get('teacher_id'));
        if ($teacherId) {
            return "Logged in Teacher ID: " . $teacherId;
        } else {
            return "No teacher is logged in!";
        }
    }

   

public function logout() {
         Session::forget('teacher_id'); 
        Auth::guard('teacher')->logout();

        return redirect()->route('teacher.login.form')->with('success', 'You have been logged out successfully.');
    }

     public function dashboard(Request $request) {
        $query = $request->input('search');
         $teacherId = Session::get('teacher_id'); 

    $teachers = Teacher::when($query, function ($queryBuilder) use ($query) {
        return $queryBuilder->where('name', 'LIKE', "%{$query}%")
                             ->orWhere('father_name', 'LIKE', "%{$query}%")
                             ->orWhere('class', 'LIKE', "%{$query}%")
                             ->orWhere('roll_number', 'LIKE', "%{$query}%");
    })
     ->when($teacherId, function ($queryBuilder) use ($teacherId) {
            return $queryBuilder->where('id', '!=', $teacherId);
        })
    ->latest() 
    ->paginate(5) 
    ->appends(['search' => $query]); 

    
    return view('teacher.dashboard', compact('teachers', 'query'))
           ->with('i', (request()->input('page', 1) - 1) * 5);

        //return view('student.dashboard');
    }
}

