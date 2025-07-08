<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StudentAuthController extends Controller
{
    public function showRegisterForm() {
        return view('auth.student_register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|min:6|confirmed',
        ]);

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('student.login.form')->with('success', 'Registration successful');
    }

    public function showLoginForm() {
        return view('auth.student_login');
    }

   public function login(Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::guard('student')->attempt($credentials)) {
       
        $student = Auth::guard('student')->user();
        Session::put('student_id', $student->id);

       
        return redirect()->route('student.dashboard')->with('success', 'Login successful! Welcome, ' . $student->name);
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}

    public function sessionget(){

         $studentId = Session::get('student_id');
//dd(Session::get('student_id'));
        if ($studentId) {
            return "Logged in Student ID: " . $studentId;
        } else {
            return "No student is logged in!";
        }
    }
    public function logout() {
         Session::forget('student_id'); 
        Auth::guard('student')->logout();

        return redirect()->route('student.login.form')->with('success', 'You have been logged out successfully.');
    }



    public function dashboard(Request $request) {
        $query = $request->input('search');
       $studentId = Session::get('student_id'); 
     $students = Student::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'LIKE', "%{$query}%")
                                ->orWhere('father_name', 'LIKE', "%{$query}%")
                                ->orWhere('class', 'LIKE', "%{$query}%")
                                ->orWhere('roll_number', 'LIKE', "%{$query}%");
        })
        ->when($studentId, function ($queryBuilder) use ($studentId) {
            return $queryBuilder->where('id', '!=', $studentId);
        })
      
        ->latest()
        ->paginate(10)
        ->appends(['search' => $query]);

       
        return view('student.dashboard', compact('students', 'query'))
               ->with('i', (request()->input('page', 1) - 1) * 10);
    }

}
