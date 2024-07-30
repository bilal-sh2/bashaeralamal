<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolClassController extends Controller
{

    public function index2($id)
    {

        $schoolid = $id;
        $schoolClasses = SchoolClass::where('school_id', $schoolid)->get();

        return view('school_class.index', compact('schoolClasses', 'id'));

    }

    /**
     * عرض قائمة الصفوف.
     */

    /**
     * عرض النموذج لإنشاء صف جديد.
     */
    public function create($id)
    {
        $schoolid = $id;


        return view('school_class.create', compact('id'));

    }

    /**
     * تخزين صف جديد في قاعدة البيانات.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            'school_id' => 'required|exists:schools,id',
        ]);

        // إنشاء الصف
        SchoolClass::create($request->all());

        // رسالة نجاح
        return back()->with('success', 'تم إنشاء الصف بنجاح.');
    }

    /**
     * عرض معلومات صف محدد.
     */
    public function show($id)
    {

        $class = $id;
        $students = Student::where('class_id', $class)->get();

        return view('school_class.show', compact('students', 'id'));

    }

    /**
     * عرض النموذج لتحرير صف محدد.
     */
    public function edit(SchoolClass $schoolClass)
    {
        $teachers = Teacher::all();
        $schools = School::all();
        return view('school-classes.edit', compact('schoolClass', 'teachers', 'schools'));
    }

    /**
     * تحديث معلومات الصف في قاعدة البيانات.
     */
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',

        ]);

        $schoolClass->update($request->all());

        return back()->with('success', 'تم تحديث الصف بنجاح.');
    }

    /**
     * حذف صف محدد من قاعدة البيانات.
     */
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();

        return back()->with('success', 'تم حذف بيانات المعلم بنجاح.');

    }

// api

public function getStudentsByClass(Request $request, $email)
    {
        // $class = $id;
        // $students = Student::where('class_id', $class)->get();

        // return response()->json(['students' => $students], 200);
        $class = SchoolClass::where('email', $email)->first();


        if (!$class) {

            return response()->json(['message' => 'لم يتم العثور على المعلم'], 404);
        }

        if (!($request->password == $class->password)) {
            return response()->json(['message' => 'كلمة المرور غير صحيحة'], 401);
        } else {
            $teacherWithClasses = SchoolClass::find($class->id);

            return response()->json(['class' => $teacherWithClasses], 200);
        }

    }

    public function getAllStudentsByClass($classid)
    {
        $students = Student::all()->where('class_id', $classid);

        return response()->json(['students' => $students], 200);
    }

}
