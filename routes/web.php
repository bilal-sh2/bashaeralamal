<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\ClassFileController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StudentsInGroupController;

use App\Http\Controllers\CoursePaymentController;


use App\Http\Controllers\StudentPaymentController;

use TCG\Voyager\Facades\Voyager;

use App\Http\Controllers\UserController;

Route::resource('/class_files',ClassFileController::class)->middleware('auth');

Route::get('/admin', function () {
  
    return view('auth.login');
});
// الدخول لصفحة العامة
Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/a', function () {
    return view('main');
})->middleware('auth');

Route::get('/student/create/{id}', [StudentController::class, 'create'])->name('student.create');
Route::get('/class_file/create/{id}', [ClassFileController::class, 'create'])->name('class_file.create');
Route::get('/class_files_index/{id}', [ClassFileController::class, 'index'])->name('class_files_index.index');

Route::get('/student/{item_id}/{class_id}', 'App\Http\Controllers\StudentController@showall')->name('student.showall')->middleware('auth');



Route::delete('/notes/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');



// Route::get('/students/{id}', [StudentController::class, 'showall'])->name('student.showall');

Route::resource('/notess',NoteController::class)->middleware('auth');

Route::get('/notes/create/{id}', [NoteController::class, 'create'])->name('notes.create');

Route::resource('/school',SchoolController::class)->middleware('auth');
Route::resource('/absences',AbsenceController::class)->middleware('auth');


Route::resource('teachers', TeacherController::class);
Route::resource('/school_class',SchoolClassController::class)->middleware('auth');
Route::resource('/student',StudentController::class)->middleware('auth');

Route::resource('/subject',SubjectController::class)->middleware('auth');


Route::get('/school_class22/{id}', 'App\Http\Controllers\SchoolClassController@index2')->name('school_class22.index2')->middleware('auth');
Route::get('/school_class2/{id}', 'App\Http\Controllers\SchoolClassController@create')->name('school_class2.create')->middleware('auth');
Route::get('/teacher22/{id}', 'App\Http\Controllers\TeacherController@create')->name('teacher22.create')->middleware('auth');
Route::get('/teacher2/{id}', 'App\Http\Controllers\TeacherController@index2')->name('teacher2.index2')->middleware('auth');

Route::delete('/students/{student}/subjects/{subject}', [StudentController::class, 'deleteSubjectGrade'])->name('deleteSubjectGrade')->middleware('auth');


Route::get('/add-subject', [StudentController::class, 'showAddSubjectForm'])->name('addSubjectForm')->middleware('auth');

Route::post('/add-subject/{student}', [StudentController::class, 'addSubjectToAllStudents'])->name('addSubjectToAllStudents')->middleware('auth');
Route::get('/view-grades', [StudentController::class, 'showGrades'])->name('showGrades')->middleware('auth');
// اضافة غياب
Route::get('/add_absenceC/{item_id}/{class_id}', 'App\Http\Controllers\AbsenceController@create')->name('add_absenceC.create')->middleware('auth');


Route::get('/back', function () {
    return view('welcome');

Route::get('/showall', 'App\Http\Controllers\StudentController@showall')->name('showall');



});

Route::get('/search_student', function () {
    return view('search_student');
})->name('search_student');

Route::post('/student/search', [StudentController::class, 'search'])->name('student.search');

Route::resource('/users',UserController::class)->middleware('isAdmin');
Auth::routes();

Route::get('/home', [App\Http\Controllers\SchoolController::class, 'route'])->name('home');
// 

// gdf

// 
// جدول الدوام اليومي للطلاب

Route::resource('item', ItemController::class);
Route::get('/item_create/create/{id}', [ItemController::class, 'create'])->name('item_create.create');
Route::get('/item_index/{id}', [ItemController::class, 'index'])->name('item_index.index');

Route::post('/student/create', [StudentController::class, 'store'])->name('student.store');
Route::get('/studentshow/{id}', [StudentController::class, 'show_studen'])->name('studentshow.show_studen');
Route::get('/student_school/{id}', [StudentController::class, 'index_school'])->name('student_school.index_school');



Route::resource('student_payments', StudentPaymentController::class);
Route::get('/student_payments/create/{id}', [StudentPaymentController::class, 'create'])->name('student_payments.create');

Route::resource('coursespayments', CoursePaymentController::class);


Route::resource('courses', CourseController::class);
Route::get('/students/school_aco1', [StudentController::class, 'index_school_aco1'])->name('students.index_school_aco1');
Route::get('/students/school_aco2', [StudentController::class, 'index_school_aco2'])->name('students.index_school_aco2');
Route::delete('/payments/{id}', [StudentPaymentController::class, 'destroy'])->name('payments.destroy');
Route::get('coursess/{student_id}', 'App\Http\Controllers\CourseController@index')->name('coursess.index');

Route::apiResource('groups', GroupController::class);
// routes/web.php


Route::resource('students_in_groups', StudentsInGroupController::class);
Route::get('/students/unpaid', [StudentController::class, 'showUnpaidStudents'])->name('students.unpaid');
Route::get('/students/index_all_aco1', [StudentController::class, 'index_all_aco1'])->name('students.index_all_aco1');
