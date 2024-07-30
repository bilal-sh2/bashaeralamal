<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\Student;


class AbsenceController extends Controller
{
    // عرض قائمة الغيابات

    public function create($id,$class_id)
    {
  $class=$class_id;
        $student = Student::find($id);   
        return view('absences.create', compact('student','class'));

    
    }


    // حفظ الغياب الجديد في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'reason' => 'required|string',
        ]);
    
        Absence::create($request->all());
    
        return redirect()->back()->with('success', 'تمت إضافة الغياب بنجاح.');
    }
    

    // عرض معلومات غياب محدد
    public function show(Absence $absence)
    {
        return view('absences.show', ['absence' => $absence]);
    }

    // عرض نموذج تحرير الغياب
    public function edit(Absence $absence)
    {
        return view('absences.edit', ['absence' => $absence]);
    }

    // تحديث الغياب في قاعدة البيانات
    public function update(Request $request, Absence $absence)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'reason' => 'required|string',
        ]);

        $absence->update($request->all());

        return redirect()->route('absences.index')
                         ->with('success','تم تحديث الغياب بنجاح.');
    }

    // حذف الغياب
    public function destroy(Absence $absence)
    {
        $absence->delete();
        return redirect()->back()->with('success', 'تمت حذف الغياب بنجاح.');

    }

// الغيابات api

public function addAbsence(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'date' => 'required|date',
        'reason' => 'required|string',
    ]);

    $absence = Absence::create([
        'student_id' => $request->student_id,
        'date' => $request->date,
        'reason' => $request->reason,
    ]);

    return response()->json(['message' => 'تمت إضافة الغياب بنجاح', 'absence' => $absence], 201);
}


// تابع API لتعديل غياب محدد
public function updateAbsence(Request $request, $id)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'date' => 'required|date',
        'reason' => 'required|string',
    ]);

    $absence = Absence::find($id);
    if (!$absence) {
        return response()->json(['message' => 'الغياب غير موجود'], 404);
    }

    $absence->update([
        'student_id' => $request->student_id,
        'date' => $request->date,
        'reason' => $request->reason,
    ]);

    return response()->json(['message' => 'تم تحديث الغياب بنجاح', 'absence' => $absence]);
}


// تابع API لحذف غياب محدد
public function deleteAbsence($id)
{
    $absence = Absence::find($id);
    if (!$absence) {
        return response()->json(['message' => 'الغياب غير موجود'], 404);
    }

    $absence->delete();

    return response()->json(['message' => 'تم حذف الغياب بنجاح']);
}





public function getStudentAbsences($student_id)
{
    $student = Student::find($student_id);
    if (!$student) {
        return response()->json(['message' => 'الطالب غير موجود'], 404);
    }

    $absences = Absence::where('student_id', $student_id)->get();
    return response()->json(['absences' => $absences]);
}





}