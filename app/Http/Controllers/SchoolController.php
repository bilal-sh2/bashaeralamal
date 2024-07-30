<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    /**
     * عرض قائمة المدارس.
     */
    

     public function index()
     {
         // الحصول على المستخدم المسجل دخوله
         $user = Auth::user();
         
         // التحقق من دور المستخدم
         if ($user->role === '1') {

            $schools = School::all();

             // إذا كان المستخدم ليس مديراً، نقوم بالوصول المدارس التي يمتلكها المستخدم
            } else {
             // إذا كان المستخدم مديراً، فسيتم عرض جميع المدارس

             $schools = $user->school()->get(); // تأكد من استخدام العلاقة schools() بدلاً من schools

         }

         // استخدم الدالة dd() لطباعة وفحص المتغير $schools
     
         // عرض البيانات في العرض
         return view('schools.index', ['schools' => $schools]);
     }
     
     public function route()
     {
        return view('main');

     }


    public function create()
    {
        // جلب قائمة المستخدمين
        $users = User::all();
    
        // إرسال قائمة المستخدمين إلى الصفحة
        return view('schools.create', ['users' => $users]);
    }

    /**
     * تخزين مدرسة جديدة في قاعدة البيانات.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'aco' => 'required|string',


            

        ]);
    
        // إنشاء مدرسة جديدة
        $school = new School();
        $school->name = $request->name;
        $school->type = $request->type;
        $school->aco = $request->aco;

        $school->save();
    
        return redirect()->route('school.index')->with('success', 'تم إنشاء المدرسة بنجاح.');
    }
    


public function teachers()
{
    return $this->hasMany(Teacher::class, 'school_id');
}

public function show($id)
{
    // قم بالحصول على بيانات المدرسة باستخدام الـ $id ومعها الصفوف المرتبطة
    $school = School::with('schoolclass')->find($id);
    // تأكد من أن تم العثور على المدرسة قبل إرسالها إلى العرض
    if ($school) {
        // إرسال الـ $id والـ $school إلى العرض مع الصفوف المرتبطة
        return view('schools.show', compact('id', 'school'));
    } else {
        // يمكنك إدراج رمز هنا للتعامل مع حالة عدم وجود المدرسة
        return view('schools.show')->with('error', 'School not found');
    }
}



public function control($id)
{
    $schoolid = $id;

    $teachers = DB::table('teachers')->where('school_id', $schoolid)->get();
   
    return view('schools.show',['teachers'=>$teachers],compact('id'));
}


    
    /**
     * عرض النموذج لتحرير مدرسة محددة.
     */
    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    /**
     * تحديث معلومات المدرسة في قاعدة البيانات.
     */
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',

        ]);

        $school->update($request->all());

        return redirect()->route('school.index')->with('success', 'تم تحديث المدرسة بنجاح.');
    }

    /**
     * حذف مدرسة محددة من قاعدة البيانات.
     */
    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('school.index')->with('success', 'تم حذف المدرسة بنجاح.');
    }

//api********
public function getStudentsByClass($classId)
{
    $schoolClass = SchoolClass::with('students')->find($classId);

    if (!$schoolClass) {
        return response()->json(['message' => 'لم يتم العثور على الصف'], 404);
    }

    $students = $schoolClass->students;

    return response()->json(['students' => $students], 200);
}
}
