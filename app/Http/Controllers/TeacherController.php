<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Session;

class TeacherController extends Controller
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
       return view('teachers.create');
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
        'email' => 'required|email|unique:teachers,email',
    'phone' => 'required|unique:teachers,phone|regex:/^[0-9]{10}$/',
    ]);


  
    if ($request->hasFile('image')) {
       
        $imageName = time() . '.' . $request->file('image')->extension();

        
        $request->file('image')->move(public_path('images'), $imageName);
    } else {
       
        return redirect()->back()->with('error', 'Image upload failed.');
    }

   
    Teacher::create([
          'name' => $request->name, 
        'father_name' => $request->father_name,
        'class' => $request->class,
        'roll_number' => $request->roll_number,
        'image' => $request->image,
        'email' => $request->email,
        'phone' => $request->phone,
        'image' => $imageName,
    ]);

   
    return redirect()->route('teacher.dashboard')->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
        {
            $teacher = Teacher::findOrFail($id);
            return view('teachers.show', compact('teacher'));
        }
    

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Teacher $teacher)
    {
        $teacher = Teacher::findOrFail($teacher->id);
        //dd( $student);
        return view('teachers.edit', compact('teacher'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        
       $request->validate([
        'name' => 'required',
        'father_name' => 'required',
        'class' => 'required',
        'roll_number' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', 
        'email' => 'required|email|unique:teachers,email,' . $teacher->id,
        'phone' => 'required|unique:teachers,phone,' . $teacher->id,
    ]);

    //$teacher = Teacher::findOrFail($id);

   
    if ($request->hasFile('image')) {
       
        if ($teacher->image && file_exists(public_path('images/' . $teacher->image))) {
            unlink(public_path('images/' . $teacher->image));
        }

       
        $imageName = time() . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path('images'), $imageName);
        $teacher->image = $imageName;
    }

  // dd($teacher);
    $teacher->update([
        'name' => $request->name,
        'father_name' => $request->father_name,
        'class' => $request->class,
        'roll_number' => $request->roll_number,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    $teacher->save();

    return redirect()->route('teacher.dashboard')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
        {
            $teacher = Teacher::findOrFail($id);
            $teacher->delete();

            return redirect()->route('teacher.dashboard')->with('success', 'teacher deleted successfully.');
        }
}
