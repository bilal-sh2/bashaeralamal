<?php

namespace App\Http\Controllers;
use App\Models\School;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class StudentController extends Controller
{

    // هذا التابع من اجل عرض بيانات الطلاب التي تم تسدد القسط
    public function showUnpaidStudents()
    {
        // الحصول على الطلاب عبر الصفوف والمدارس حيث يكون عمود 'aco' = 'فصلي'
        $students = Student::select('students.*')
            ->join('school_classes', 'students.class_id', '=', 'school_classes.id')
            ->join('schools', 'school_classes.school_id', '=', 'schools.id')
            ->where('schools.aco', 'فصلي')
            ->with('payments')
            ->get()
            ->filter(function ($student) {
                $totalPaid = $student->payments->sum('amount');
                return $totalPaid < $student->value_price;
            });

        return view('students.showUnpaidStudents', compact('students'));
    }
    /**
     * Display a listing of the resource.
     */
    public function search(Request $request)
    {
        $studentId = $request->input('student_id');
        $student = Student::find($studentId);

        return view('search_student', compact('student'));
    }

    public function index1()
    {
        $total_students = Student::count(); // استخدم count() لجلب عدد الطلاب
        return view('welcome', compact('total_students'));
    }

    public function index_school($id)
    {
        // Retrieve the school with the given ID
        $school = School::find($id);
    
        // Check if the school exists
        if (!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }
    
        // Get all students associated with the school
        $students = $school->students;
    
        // Return the students to the view
        return view('students.index', compact('students'));
    }
    // لجلب جميع طلاب فوق الثامن
    public function index_school_aco1()
    {
        // Retrieve the school with the given ID
    // Get the 'aco' value "مادة"
    $desiredAco = 'مادة';

    // Get all students whose class's school has the specified 'aco' value
    $students = Student::whereHas('class.school', function ($query) use ($desiredAco) {
        $query->where('aco', $desiredAco);
    })->get();

    // Return the students to the view
    return view('students.index_aco1', compact('students'));
    }

// لجلب تحت الثامن
       
    public function index_school_aco2()
    {
    // Get the 'aco' value "مادة"
    $desiredAco = 'فصلي';

    // Get all students whose class's school has the specified 'aco' value
    $students = Student::whereHas('class.school', function ($query) use ($desiredAco) {
        $query->where('aco', $desiredAco);
    })->get();

    // Return the students to the view
    return view('students.index_aco2', compact('students'));
    }
    // لعرض جميع طلاب المادة
    public function index_all_aco1() {
       // Get the 'aco' value "مادة"
       $desiredAco = 'مادة';

       // Get all students whose class's school has the specified 'aco' value
       $students = Student::whereHas('class.school', function ($query) use ($desiredAco) {
           $query->where('aco', $desiredAco);
       })->with('courses.payments')->get();
   
       // Return the students to the view
       return view('students.index_all_aco1', compact('students'));
    }
    

    


    
    public function index()
    {
        // افترض أن لديك جلسة مستخدم متوفرة تمكنك من الوصول إلى المستخدم الحالي
        $user = Auth::user();
    
        // تحقق من دور المستخدم إذا كان 0 (أي مسؤول)
        if ($user->role == 1) {
            // إذا كان المستخدم مسؤول، احصل على جميع الطلاب مباشرة دون الحاجة للتحقق من المدرسة والصفوف
            $students = Student::all();
            return view('students.index', compact('students'));
        } else {
            // تحقق من مرتبط المستخدم بمدرسة
            if ($user->school) {
                // احصل على الصفوف المرتبطة بالمدرسة
                $schoolClasses = $user->school->schoolClasses;
    
                // التحقق من أن $schoolClasses ليس فارغًا وليس مساويًا لـ null
                if (!empty($schoolClasses)) {
                    // جمع بيانات الطلاب من الصفوف
                    $students = collect();
                    foreach ($schoolClasses as $class) {
                        $students = $students->merge($class->students);
                    }
    
                    return view('students.index', compact('students'));
                } else {
                    // يمكنك تنفيذ إجراء معين كإرجاع رسالة خطأ أو تحويله إلى صفحة أخرى
                    return redirect('/')->with('error', 'لا توجد صفوف مرتبطة بالمدرسة');
                }
            } else {
                // إذا لم يكن المستخدم مرتبطًا بمدرسة، يمكنك تنفيذ إجراء معين كإرجاع رسالة خطأ أو تحويله إلى صفحة أخرى
                return redirect('/')->with('error', 'لا يوجد مدرسة مرتبطة بحسابك');
            }
        }
    }
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $id = $request->id;
        // يمكنك استخدام المعرف (id) هنا في العمليات اللاحقة
        return view('students.create', ['id' => $id]);
    }
    /**
     * Store a newly created resource in storage.
     */
 
     public function store(Request $request)
     {
         // تأكيد الصحة وحفظ الطالب في قاعدة البيانات
         $request->validate([
             'name' => 'required|string',
             'email' => ['required', 'string', 'email', 'max:255', 'unique:students,email'],
             'password' => 'required|string',
             'gender' => 'required|string',
             'class_id' => 'required|exists:school_classes,id',
             'parent_phone1' => 'nullable|string',
             'parent_phone2' => 'nullable|string',
             'birthdate' => 'nullable|date',
             'address' => 'nullable|string',
             'value_price' => 'nullable|string',
             'mimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);
     
         // استخراج كل البيانات من الطلب
         $input = $request->all();
     
         // التحقق من وجود صورة مُرفقة
         if ($request->hasFile('mimage')) {
             $image = $request->file('mimage');
             $imageName = time() . '.' . $image->extension();
             $image->storeAs('images_s', $imageName);
             $imagePath = '/' . $imageName;
             $imageUrl = asset(str_replace('images/', '', $imagePath));
                  
             // حفظ المسار الكامل للصورة في قاعدة البيانات
             $input['image'] = $imagePath;
         }
     
         // إنشاء نموذج Student وملء البيانات
         $student = new Student();
         $student->fill($input); // ملء البيانات من مصفوفة $input
         $student->save();
     
         return back()->with('success', 'تم إضافة طالب جديد بنجاح');
     }
     
     
     
     
    /**
     * Display the specified resource.
     */

    public function showall($item_id, $class_id)
    {
        // العثور على الطالب باستخدام المعرف المحدد
        $student = Student::with('schoolClass', 'subjects', 'absences', 'notes')->find($item_id);

        // إرسال الـ class_id إلى العرض
        return view('students.show', compact('student', 'class_id'));
    }

    public function show(Student $student)
    {
        // الحصول على الصف الذي ينتمي إليه الطالب
        $class = $student->class;
    
        if (!$class) {
            return response()->json(['error' => 'Student is not associated with any class.'], 404);
        }
    
        // الحصول على المدرسة التي ينتمي إليها الصف
        $school = $class->school;
    
        if (!$school) {
            return response()->json(['error' => 'Class is not associated with any school.'], 404);
        }
    
        // الحصول على المواد المرتبطة بالمدرسة
        $subjects = $school->subject;
    
        return view('students.add_grade', compact('student', 'subjects'));
    }
    public function show_studen($id)
    {
        $student = Student::find($id);
        // Return the view or data you want to show
        return view('students.showst', compact('student'));
    }
    //
    public function showabseces($id)
    {

        $student = Student::find($id);
        return view('absences.create', compact('student'));

    }

    public function edit(Student $student)
    {
        // يمكنك عرض نموذج التعديل هنا إذا كنت بحاجة إلى ذلك
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // تأكيد الصحة وتحديث بيانات الطالب

        $student->update($request->all());

        return back()->with('success', 'تم تعديل بيانات الطالب بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return back()->with('error', 'تم حف بيانات الطالب  بنجاح.');
    }

    public function showAddSubjectForm()
    {
        $subjects = Subject::all();
        return view('addSubject', compact('subjects'));
    }

    public function deleteSubjectGrade($studentId, $subjectId)
    {
        $student = Student::find($studentId);
        $subject = Subject::find($subjectId);

        if ($student && $subject) {
            $student->subjects()->detach($subject->id);
            return back()->with('success', 'تم حذف علامة الطالب  بنجاح.');
        }

        return redirect()->back()->with('error', 'خطأ في العثور على الطالب أو المادة.');
    }

    public function addSubjectToAllStudents(Request $request, $studentId)
    {
        $subjectId = $request->input('subject');
        $grade = $request->input('grade');

        $subject = Subject::find($subjectId);
        $student = Student::find($studentId);

        if ($student && $subject) {
            $student->subjects()->attach($subject, ['grade' => $grade]);
            return redirect()->back()->with('success', 'تمت إضافة علامة للطالب بنجاح.');
        }

        return redirect()->back()->with('error', 'خطأ في العثور على الطالب أو المادة.');
    }

    public function showGrades()
    {
        $students = Student::all();
        return view('viewGrades', compact('students'));
    }

// api add grade subject

    public function addSubjectToAllStudents_api(Request $request, $studentId)
    {
        $subjectId = $request->input('subject');
        $grade = $request->input('grade');

        $subject = Subject::find($subjectId);
        $student = Student::find($studentId);

        if ($student && $subject) {
            $student->subjects()->attach($subject, ['grade' => $grade]);
            return response()->json(['message' => 'تمت إضافة علامة للطالب بنجاح.']);
        }

        return response()->json(['message' => 'خطأ في العثور على الطالب أو المادة.'], 404);
    }

// get data subject
public function getSubjectsBySchool($school_id)
{
    $school = School::find($school_id); // البحث عن السجل للمدرسة باستخدام الـ id الممرر

    if (!$school) {
        return response()->json(['error' => 'School not found'], 404); // إذا لم يتم العثور على المدرسة، إرجاع رسالة خطأ
    }

    $subjects = $school->subjects; // الحصول على المواد المرتبطة بالمدرسة

    return response()->json(['subjects' => $subjects]);
}

// show gradw
    public function getStudentGrades($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['error' => 'طالب غير موجود.'], 404);
        }

        $grades = $student->subjects()->withPivot('grade')->get();

        return response()->json(['student' => $student, 'grades' => $grades]);
    }

// لعرض بيانات الطالب

// api


public function getStudent(Request $request, $email)
{
    $std = Student::with('schoolClasses', 'subjects', 'absences', 'notes', 'school')->where('email', $email)->first();

    if (!$std) {
        return response()->json(['message' => 'لم يتم العثور على الطالب'], 404);
    }

    if (!($request->password == $std->password)) {
        return response()->json(['message' => 'كلمة المرور غير صحيحة'], 401);
    } else {
        // تجلب id الصف المرتبط بالطالب
        $classId = $std->schoolClasses->first()->id;

        // تضمين id الصف مع البيانات المسترجعة
        $datastudent = [
            'id' => $std->id,
            'name' => $std->name,
            'email' => $std->email,
            'class_id' => $classId, // هنا نضيف id الصف
            'subjects' => $std->subjects,
            'absences' => $std->absences,
            'notes' => $std->notes,
            'school' => $std->school,
        ];

        return response()->json(['student' => $datastudent], 200);
    }
}


    public function deleteSubjectGrade_api(Request $request, $studentId, $subjectId)
    {
        $student = Student::find($studentId);
        $subject = Subject::find($subjectId);

        if ($student && $subject) {
            $student->subjects()->detach($subject->id);
            return response()->json(['message' => 'تم حذف علامة الطالب بنجاح.'], 200);
        }

        return response()->json(['error' => 'خطأ في العثور على الطالب أو المادة.'], 404);
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

