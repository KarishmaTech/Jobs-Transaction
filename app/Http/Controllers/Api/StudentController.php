<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function register(Request $request)
    {
       // dd('hh');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $student->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Student registered successfully',
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        
        $student = Student::where('email', $request->email)->first();

       
        if (!$student || !Hash::check($request->password, $student->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $student->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'student' => $student
        ]);
    }

     public function logout(Request $request)
    {
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Student logged out successfully'
        ]);
    }

     public function index(Request $request)
    {
        //dd("h");
        
        $query = Student::query();

        
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        
        $students = $query->paginate(10); 

        return response()->json([
            'status' => true,
            'message' => 'Students fetched successfully',
            'data' => $students
        ]);
    }

     public function show($id)
    {
        
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Student details fetched successfully',
            'data' => $student
        ]);
    }

     public function update(Request $request, $id)
    {
       
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found'
            ], 404);
        }

       
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:students,email,' . $id,
            'phone' => 'sometimes|required|numeric|digits:10|unique:students,phone,' . $id,
            'password' => 'sometimes|required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        
        $student->update([
            'name' => $request->name ?? $student->name,
            'email' => $request->email ?? $student->email,
            'phone' => $request->phone ?? $student->phone,
            'password' => $request->password ? bcrypt($request->password) : $student->password
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Student updated successfully',
            'data' => $student
        ]);
    }

}

