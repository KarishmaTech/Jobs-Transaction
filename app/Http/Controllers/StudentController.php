<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Session; 

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'father_name' => 'required',
        'class' => 'required',
        'roll_number' => 'required',
        'image' => 'required', 
         'email' => 'required|email|unique:students,email',
    'phone' => 'required|unique:students,phone|regex:/^[0-9]{10}$/',
    ]);

  
    if ($request->hasFile('image')) {
       
        $imageName = time() . '.' . $request->file('image')->extension();

        
        $request->file('image')->move(public_path('images'), $imageName);
    } else {
       
        return redirect()->back()->with('error', 'Image upload failed.');
    }

   
    Student::create([
          'name' => $request->name, 
        'father_name' => $request->father_name,
        'class' => $request->class,
        'roll_number' => $request->roll_number,
        'image' => $request->image,
        'email' => $request->email,
        'phone' => $request->phone,
        'image' => $imageName,
    ]);

   
    return redirect()->route('student.dashboard')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $student = Student::findOrFail($id);
    return view('students.show', compact('student'));
}
    

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Student $student)
    {
        $student = Student::findOrFail($student->id);
        //dd( $student);
        return view('students.edit', compact('student'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        
       $request->validate([
        'name' => 'required',
        'father_name' => 'required',
        'class' => 'required',
        'roll_number' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', 
        'email' => 'required|email|unique:students,email,' . $student->id,
        'phone' => 'required|unique:students,phone,' . $student->id,
    ]);

   

   
    if ($request->hasFile('image')) {
       
        if ($student->image && file_exists(public_path('images/' . $student->image))) {
            unlink(public_path('images/' . $student->image));
        }

       
        $imageName = time() . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path('images'), $imageName);
        $student->image = $imageName;
    }

  // dd($student);
    $student->update([
        'name' => $request->name,
        'father_name' => $request->father_name,
        'class' => $request->class,
        'roll_number' => $request->roll_number,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    $student->save();

    return redirect()->route('student.dashboard')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
     
     public function destroy($id)
        {
            $student = Student::findOrFail($id);
            $student->delete();

            return redirect()->route('student.dashboard')->with('success', 'Student deleted successfully.');
        }
}
