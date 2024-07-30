<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::with('school')->get(); // استخدام with() لجلب بيانات المدرسة

        return view('subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
  /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{

        $request->validate([

    'name' => 'required|string',
    'school_id'=>'required',
    ]);
        Subject::create($request->all());


return back()->with('success', 'تم اضفاة المادة بنجاح بنجاح.');

}


    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {


        $request->validate([
            'name' => 'required|string',
        ]);

        $subject->update($request->all());

        return back()->with('success', 'تم تحديث  بيانات المادة بنجاح.');



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return back()->with('success', 'تم حذف المادة  بنجاح.');
    }



// api

}
