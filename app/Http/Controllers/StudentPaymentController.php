<?php



namespace App\Http\Controllers;
use App\Models\Student;

use App\Models\StudentPayment;
use Illuminate\Http\Request;

class StudentPaymentController extends Controller
{
    public function index()
    {
        $payments = StudentPayment::all();
        return view('student_payments.index', compact('payments'));
    }




    public function create($id)
    {
        $student = Student::find($id);   

        return view('payment.create',compact('student'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
            
            'user' => 'nullable|string',
            'payment_type' => 'nullable|string',

        ]);

        StudentPayment::create($request->all());
        return back()->with('success', 'تم إضافة دفعة مالية طالب جديد بنجاح');
    }


    public function show($id)
    {
        // احصل على بيانات الطالب وكل دفعاته
        $payments = StudentPayment::with('student')->where('student_id', $id)->get();
        $student = Student::find($id);
    
        // تأكد من وجود الطالب والدفعات قبل عرضها
        if ($student && $payments->isNotEmpty()) {
            // حساب المبلغ المدفوع الكلي
            $totalPaidAmount = $payments->sum('amount');
            
            // احسب المتبقي
            $remainingAmount = $student->value_price - $totalPaidAmount;
    
            return view('payment.show', compact('payments', 'student', 'totalPaidAmount', 'remainingAmount'));
        } else {
            // إرسال رسالة خطأ إذا لم توجد بيانات
            return view('payment.show')->with('error', 'Payment records not found for this student.');
        }
    }
    
    



    public function edit(StudentPayment $studentPayment)
    {
        return view('student_payments.edit', compact('studentPayment'));
    }

    public function update(Request $request, StudentPayment $studentPayment)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
            'user' => 'nullable|string',
            'payment_type' => 'nullable|string',


        ]);

        $studentPayment->update($request->all());
        return redirect()->route('student_payments.index');
    }
    public function destroy($id)
    {
        $payment = StudentPayment::find($id);
        if (!$payment) {
            return back()->with('error', 'Payment not found.');
        }
    
        $payment->delete();
    
        return back()->with('success', 'تم حذف دفعة مالية طالب جديد بنجاح');
    }
    

// api
    public function getStudentPayments($student_id)
    {
        // استعلام للحصول على جميع دفعات المالية للطالب المحدد
        $payments = StudentPayment::where('student_id', $student_id)->get();

        return response()->json(['payments' => $payments]);
    }
}
