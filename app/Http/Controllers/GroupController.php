<?php

// app/Http/Controllers/GroupController.php
namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
    }

    public function create()
    {
        $teachers = Teacher::all();
        return view('groups.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_course' => 'required|string|max:255',

            'teacher_id' => 'required|exists:teachers,id',
        ]);

        Group::create($validated);
        return back()->with('success', 'تم إضافة المجموعة جديد بنجاح');
    }

    public function show($id)
    {
        $group = Group::with('students')->findOrFail($id);
        return view('groups.show', compact('group'));
    }

    public function edit($id)
    {
        $group = Group::findOrFail($id);
        $teachers = Teacher::all();
        return view('groups.edit', compact('group', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'name_course' => 'required|string|max:255',

            'teacher_id' => 'sometimes|required|exists:teachers,id',
        ]);

        $group = Group::findOrFail($id);
        $group->update($validated);
        return back()->with('success', 'تم إضافة المجموعة جديد بنجاح');
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return back()->with('success', 'تم إضافة المجموعة جديد بنجاح');
    }
}
