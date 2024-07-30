<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ClassFileController;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursePaymentController;
use App\Http\Controllers\StudentPaymentController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Route::post('/teachers/{teacherId}', [TeacherController::class, 'getTeacherWithClasses']);
// لجلب بيانات الطالب
//تسجيل دخول الطالب
Route::post('/getStudent/{email}', [StudentController::class, 'getStudent']);

// لجلب بيانات الطلاب 
// تسجيل الدخول الى الكلاس
Route::post('/get-students/{email}', [SchoolClassController::class, 'getStudentsByClass']);

// جلب جميع الطلاب في الكلاس
Route::get('/get-class-students/{classId}', [SchoolClassController::class, 'getAllStudentsByClass']);

// لجلب جميع المواد


// اضافة العلامة للطالب
Route::post('addSubjectToAllStudents_api/{studentId}', [StudentController::class, 'addSubjectToAllStudents_api']);

// لعرض علامات الطالب
Route::get('/student/{id}', [StudentController::class, 'getStudentGrades'])->name('student.getGrades');

// حذف العلامة

Route::delete('/students/{studentId}/subjects/{subjectId}', [StudentController::class, 'deleteSubjectGrade_api'])->name('student.subjects.delete');


// لحذف علامات الطالب
Route::get('/student/{id}', [StudentController::class, 'getStudentGrades'])->name('student.getGrades');

// للغيابات
// اضافة
Route::post('/addAbsence/{student_id}/', [AbsenceController::class, 'addAbsence']);




// Route::post('/absences/add', 'AbsenceController@addAbsence');
// تعديل
Route::put('/absences/{id}', 'AbsenceController@updateAbsence');

// حذف
    
Route::delete('/absences-delete/{id}/', [AbsenceController::class, 'deleteAbsence']);
// عرض


Route::get('/get-absences/{student_id}/', [AbsenceController::class, 'getStudentAbsences']);
// اضافة الملاحظات


Route::post('/notes/{student_id}/', [NoteController::class, 'store_api']);


Route::delete('/notes/{note}', [NoteController::class, 'destroy_api']);
Route::put('/notes/{note}', [NoteController::class, 'update_api']);

Route::get('/get-notes/{student_id}/', [NoteController::class, 'getStudentNotes']);


// الملفات

Route::prefix('class-files')->group(function ()
 {
    Route::post('/', [ClassFileController::class, 'store_api']); // لإنشاء ملف جديد
    Route::get('/{id}', [ClassFileController::class, 'show_api']); // لعرض ملف محدد
    Route::delete('/{id}', [ClassFileController::class, 'destroy_api']); // حذف ملف محدد

});
Route::prefix('items')->group(function () {
    Route::get('/', [ItemController::class, 'apiIndex']); // لعرض كل العناصر
    Route::post('/', [ItemController::class, 'apiStore']); // لإنشاء عنصر جديد
    Route::get('/{item}', [ItemController::class, 'apiShow']); // لعرض عنصر محدد
    Route::put('/{item}', [ItemController::class, 'apiUpdate']); // لتحديث عنصر محدد
    Route::delete('/{item}', [ItemController::class, 'apiDestroy']); // لحذف عنصر محدد
});



// بلال الوحش ركز هون عندك خاص لطلاب يلي فوق صف ثامن بتعطي رقم الطالب كرمال يجبلك كل المواد يلي مرتبطة فيه
Route::get('/student/courses/{student_id}', [CourseController::class, 'getCoursesByStudent'])
    ->name('api.student.courses');

// للدفعات المرتبطة بالكورس
// اما هون بتعطي رقم المادة يلي اخدها الطالب بيعطيك الدفعات الها
Route::get('/course/payments/{course_id}', [CoursePaymentController::class, 'getPaymentsByCourse'])
    ->name('api.course.payments');

// اما هاد لتحت الصف التاسع بتعطي بس رقم بيعطيك دفعاتو 
    Route::get('/student/payments/{student_id}', [StudentPaymentController::class, 'getStudentPayments'])
    ->name('api.student.payments');

    // بالنسبة للمواد تغير اسم التابع تبعها ركز منيح غيرو من عندك لازم تبعتلي رقم المدرسة لابعتلك المواد المتربطة فيها

    Route::get('/student_subject/{school_id}', [StudentController::class, 'getSubjectsBySchool'])
    ->name('student_subject.getSubjectsBySchool');

// هون يابلال بتعمل تسجيل دخول للمعلم يلي بدرس بمعهد بجبلك كل المجموعات المرتبطة فيه
    Route::post('/get-groups/{email}', [TeacherController::class, 'getGroups']);
