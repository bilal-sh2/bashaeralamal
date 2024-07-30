@extends('layouts.index')

@section('content')

<style>
    .large-text {
        font-size: 3.5rem;
    }
    .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .card-body {
        font-size: 1.5rem;
    }
</style>

<div class="container large-text">
    <div class="row">
        <div class="col-md-8 offset-md-2">         
            <!-- معلومات الطالب -->
            <div class="card mb-3">
                <div class="card-header">
                    معلومات الطالب
                </div>
                <div class="card-body">
                    <p><strong>الاسم:</strong> {{ $student->name }}</p>


                    <p><strong>الجنس:</strong> {{ $student->gender }}</p>


                    <p><strong>اسم الصف:</strong> {{ $student->class->school->name }}</p>


                    <p><strong>رقم الشعبة:</strong> {{ $student->class->name }}</p>

                    <div class="col-xl-40 col-lg-7 col-md-6">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="d-flex align-items-end justify-content-center h-100"></div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <a href="javascript:void(0)" data-bs-target="#addRoleModal" data-bs-toggle="modal" class="stretched-link text-nowrap add-new-role">
                                    <span class="btn btn-primary mb-1">اضافة مادة جديدة</span>
                                </a>
                                <p class="mb-0">يمكنك من هنا اضافة مواد جديدة</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                </div>
            </div>
    
        <!-- Role cards -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5 pb-5">
                        <div class="text-center mb-4">
                            <h1 class="role-title">Add New Role</h1>
                            <p>Set role permissions</p>
                        </div>

                        <!-- Form to add a new course -->
                        <form action="{{ route('courses.store') }}" method="POST" id="addCourseForm" class="row">
                            @csrf
                            <div class="col-12 mb-3">
                                <label class="form-label" for="name">اسم المادة</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter course name" required data-msg="الرجاء ادخال اسم المادة" />
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="name_teacher">اسم المدرس</label>
                                <input type="text" id="name_teacher" name="name_teacher" class="form-control" placeholder="Enter teacher name" required data-msg="ادخال مدرس المادة" />
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="value_price">القيمة المالي لقسط المادة</label>
                                <input type="number" id="value_price" name="value_price" class="form-control" placeholder="Enter course fee" required data-msg="القسط الخاص بالمادة" />
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="student_id">رقم الطالب</label>
                                <input type="text" id="student_id" name="student_id" class="form-control" value="{{ $student_id }}" readonly />
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">إضافة المادة</button>
                            </div>
                        </form>
                        <!-- End of form -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Display courses and payments -->
        @foreach ($courses as $course)
            @php
                $totalPaid = $course->payments->sum('amount');
                $remaining = $course->value_price - $totalPaid;
            @endphp
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>بيانات المالية للمادة</span>
                    <!-- Button to trigger payment modal -->
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addPaymentModal-{{ $course->id }}">إضافة دفعة</button>
                </div>
                <div class="card-body">
                    <p><strong>أسم المادة:</strong> {{ $course->name }}</p>
                    <p><strong>أسم المعلم:</strong> {{ $course->name_teacher }}</p>
                    <p><strong>قسط المادة:</strong> {{ $course->value_price }}</p>
                    <p><strong>المدفوع:</strong> {{ $totalPaid }}</p>
                    <p><strong>المتبقي:</strong> {{ $remaining }}</p>
                </div>

                <div class="card">
                    <div class="card-header">الدفعات المالية للمادة</div>
                    <div class="card-body">
                        @if ($course->payments->isEmpty())
                            <p>No payments found for this course.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">المبلغ المدفوع</th>
                                        <th scope="col">تاريخ الدفع</th>
                                        <th scope="col">نمط الدفع</th>
                                        <th scope="col">ملاحظات</th>
                                        <th scope="col">المستخدم الذي اتم العملية</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($course->payments as $payment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $payment->amount }}</td>
                                            <td>{{ $payment->payment_date }}</td>
                                            <td>{{ $payment->payment_method }}</td>
                                            <td>{{ $payment->notes ?? 'N/A' }}</td>
                                            <td>{{ $payment->user ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal to add payment -->
            <div class="modal fade" id="addPaymentModal-{{ $course->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-payment">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-5 pb-5">
                            <div class="text-center mb-4">
                                <h1 class="role-title">إضافة دفعة جديدة</h1>
                            </div>

                            <!-- Form to add a new payment -->
                            <form action="{{ route('coursespayments.store') }}" method="POST" id="addPaymentForm" class="row">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" id="user" value=" {{ Auth::user()->name }}" name="user" class="form-control" placeholder="Enter user" />

                                <div class="col-12 mb-3">
                                    <label class="form-label" for="amount">المبلغ المدفوع</label>
                                    <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount" required />
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label" for="payment_date">تاريخ الدفع</label>
                                    <input type="date" id="payment_date" name="payment_date" class="form-control" required />
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label" for="payment_method">نمط الدفع</label>
                                    <input type="text" id="payment_method" name="payment_method" class="form-control" placeholder="Enter payment method" required />
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label" for="notes">ملاحظات</label>
                                    <input type="text" id="notes" name="notes" class="form-control" placeholder="Enter notes" />
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">إضافة الدفعة</button>
                                </div>
                            </form>
                            <!-- End of form -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of modal -->
        @endforeach
    </div>
</div>
@endsection
