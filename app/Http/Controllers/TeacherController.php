<?php
// app/Http/Controllers/TeacherController.php
namespace App\Http\Controllers;
use App\Models\Student;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:teachers',
            'password' => 'required|string|min:8'
        ]);

        $teacher = Teacher::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' =>$validated['password'],
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

// app/Http/Controllers/TeacherController.php

public function show($id)
{
    $teacher = Teacher::with('groups.students')->findOrFail($id);
    $students = Student::all(); // Fetch all students

    return view('teachers.show', compact('teacher', 'students'));
}


    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:teachers,email,' . $teacher->id,
            'password' => 'sometimes|nullable|string|min:8'
        ]);

        if ($request->has('password') && $request->password) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $teacher->update($validated);
        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }

    // هذا التابع يجلب بيانات المجموعة
    public function getGroups(Request $request, $email)
    {
        // العثور على المعلم باستخدام البريد الإلكتروني
        $teacher = Teacher::where('email', $email)
            ->with('groups.students') // تحميل المجموعات والطلاب المرتبطين
            ->first();
    
        // إذا لم يتم العثور على المعلم
        if (!$teacher) {
            return response()->json(['message' => 'لم يتم العثور على المعلم'], 404);
        }
    
        // التحقق من صحة كلمة المرور
        if (!Hash::check($request->password, $teacher->password)) {
            return response()->json(['message' => 'كلمة المرور غير صحيحة'], 401);
        }
    
        // إذا كانت كلمة المرور صحيحة، استرجاع بيانات المعلم مع المجموعات والطلاب
        return response()->json([
            'teacher' => $teacher,
            'groups' => $teacher->groups
        ], 200);
    }
    
}
