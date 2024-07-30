<?php

// app/Http/Controllers/StudentsInGroupController.php

namespace App\Http\Controllers;
use App\Models\Student;

use App\Models\StudentsInGroup;
use Illuminate\Http\Request;

class StudentsInGroupController extends Controller
{
    public function index()
    {
        $students = StudentsInGroup::all();
    }

    public function create()
    {
        return view('students_in_groups.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'student_id' => 'required|exists:students,id', // Ensure the student_id exists in the students table
        ]);
    
        // Retrieve the student based on the provided student_id
        $student = Student::findOrFail($validated['student_id']);
    
        // Prepare the data for creation
        $data = [
            'group_id' => $validated['group_id'],
            'student_id' => $validated['student_id'],
            'student_name' => $student->name, // Retrieve the student name from the Student model
        ];
    
        // Create a new entry in the StudentsInGroup table
        StudentsInGroup::create($data);
    
        // Redirect back with a success message
        return back()->with('success', 'تم إضافة الطالب إلى المجموعة بنجاح');
    }
    

    public function show($id)
    {
        $student = StudentsInGroup::findOrFail($id);
        return view('students_in_groups.show', compact('student'));
    }

    public function edit($id)
    {
        $student = StudentsInGroup::findOrFail($id);
        return view('students_in_groups.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'student_name' => 'required|string|max:255',
        ]);

        $student = StudentsInGroup::findOrFail($id);
        $student->update($validated);
        return redirect()->route('students_in_groups.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $student = StudentsInGroup::findOrFail($id);
        $student->delete();
        return redirect()->route('students_in_groups.index')->with('success', 'Student deleted successfully.');
    }
}
