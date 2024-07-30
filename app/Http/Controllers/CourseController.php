<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

use App\Models\Student;

class CourseController extends Controller
{
    public function index($student_id)
    {    $student = Student::find($student_id); // البحث عن الطالب باستخدام الـ id المعطى

        // استخدم $student_id لاسترجاع المواد المرتبطة بالطالب
        $courses = Course::where('student_id', $student_id)->get();
        return view('courses.index', compact('courses','student_id','student'));
    }
    
    

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_teacher' => 'required|string|max:255',
            'value_price' => 'required|string|max:255',
            'student_id' => 'required|exists:students,id',
        ]);

        Course::create($request->all());
        return back()->with('success', 'تم إضافة طالب جديد بنجاح');
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_teacher' => 'required|string|max:255',
            'value_price' => 'required|string|max:255',
            'student_id' => 'required|exists:students,id',
        ]);

        $course = Course::findOrFail($id);
        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }



    

    public function getCoursesByStudent($student_id)
    {
        $student = Student::find($student_id);

        if (!$student) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        $courses = $student->courses()->get();

        return response()->json(['courses' => $courses]);
    }


    
}
