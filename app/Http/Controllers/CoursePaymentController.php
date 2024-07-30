<?php
namespace App\Http\Controllers;

use App\Models\CoursePayment;
use Illuminate\Http\Request;
use App\Models\Course;

class CoursePaymentController extends Controller
{
    public function index()
    {
        $coursePayments = CoursePayment::all();
        return view('course_payments.index', compact('coursePayments'));
    }

    public function create()
    {
        return view('course_payments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'user' => 'nullable|string',

        ]);

        CoursePayment::create($request->all());
        return back()->with('success', 'تم إضافة دفعة جديد بنجاح');
    }

    public function show($id)
    {
        $coursePayment = CoursePayment::findOrFail($id);
        return view('course_payments.show', compact('coursePayment'));
    }

    public function edit($id)
    {
        $coursePayment = CoursePayment::findOrFail($id);
        return view('course_payments.edit', compact('coursePayment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'user' => 'nullable|string',

        ]);

        $coursePayment = CoursePayment::findOrFail($id);
        $coursePayment->update($request->all());
        return redirect()->route('course_payments.index')->with('success', 'تم تحديث الدفعة بنجاح');
    }

    public function destroy($id)
    {
        $coursePayment = CoursePayment::findOrFail($id);
        $coursePayment->delete();
        return redirect()->route('course_payments.index')->with('success', 'تم حذف الدفعة بنجاح');
    }


    public function getPaymentsByCourse($course_id)
    {
        $course = Course::find($course_id);

        if (!$course) {
            return response()->json(['error' => 'Course not found.'], 404);
        }

        $payments = $course->payments()->get();

        return response()->json(['payments' => $payments]);
    }

    
}
