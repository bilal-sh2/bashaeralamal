<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\Student;

class NoteController extends Controller
{

    public function create(Request $request)
    {
        $id = $request->id;
        return view('Notes.create', ['id' => $id]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required',
            'notes' => 'required',
        ]);

        Note::create($request->all());

        return back()->with('success', 'تم إضافة ملاحظة طالب جديد بنجاح');
    }

    public function show(Note $note)
    {
        // عرض تفاصيل الملاحظة
    }

    public function edit(Note $note)
    {
        // عرض الاستمارة لتعديل الملاحظة
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required',
            'notes' => 'required',
        ]);

        $note->update($request->all());

        return redirect()->route('notes.index')->with('success', 'تم تحديث الملاحظة بنجاح');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->back()->with('success', 'تمت حذف الملاحظة بنجاح.');
    }

// api

    public function store_api(Request $request)
    {

        $request->validate([
            'student_id' => 'required',
            'type' => 'required',
            'notes' => 'required',
        ]);

        $note = Note::create([
            'student_id' => $request->student_id,
            'type' => $request->type,
            'notes' => $request->notes,
        ]);

        return response()->json(['message' => 'تمت إضافة الغياب بنجاح', 'note' => $note], 201);

        // $request->validate([
        //     'student_id' => 'required|exists:students,id',
        //     'type' => 'required',
        //     'notes' => 'required',
        // ]);

        // $note = Note::create($request->all());

        // return response()->json(['message' => 'تمت إضافة الملاحظة بنجاح', 'note' => $note], 201);
    }

// api
    public function destroy_api(Note $note)
    {
        $note->delete();

        return response()->json(['message' => 'تم حذف الملاحظة بنجاح'], 200);
    }
    public function update_api(Request $request, Note $note)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required',
            'notes' => 'required',
        ]);

        $note->update($request->all());

        return response()->json(['message' => 'تم تعديل الملاحظة بنجاح', 'note' => $note], 200);
    }

    public function getStudentNotes($student_id)
    {
        $student = Student::find($student_id);
        if (!$student) {
            return response()->json(['message' => 'الطالب غير موجود'], 404);
        }

        $notes = Note::where('student_id', $student_id)->get();
        return response()->json(['notes' => $notes]);
    }

}
