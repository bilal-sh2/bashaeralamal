@extends('layouts.index')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
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
    .badge-paid {
        background-color: #28a745;
        color: white;
    }
    .badge-partial {
        background-color: #ffc107;
        color: black;
    }
    .badge-unpaid {
        background-color: #dc3545;
        color: white;
    }
    .search-container {
        margin-bottom: 20px;
    }
    .student-header {
        color: #007bff;
    }
</style>

<div class="container large-text">
    <div class="row search-container">
        <div class="col-md-4">
            <input type="text" id="searchNameInput" class="form-control" placeholder="بحث باسم الطالب">
        </div>
        <div class="col-md-4">
            <input type="text" id="searchClassInput" class="form-control" placeholder="بحث باسم الصف">
        </div>
        <div class="col-md-4">
            <input type="text" id="searchSectionInput" class="form-control" placeholder="بحث برقم الشعبة">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary mb-3" id="printPdf">طباعة البيانات بملف PDF</button>
            @foreach ($students as $student)
                <div class="card student-card mb-3" data-name="{{ $student->name }}" data-class="{{ $student->class->school->name }}" data-section="{{ $student->class->name }}">
                    <div class="card-header student-header">
                        معلومات الطالب: {{ $student->name }}
                    </div>
                    <div class="card-body">
                        <p><strong>الاسم:</strong> {{ $student->name }}</p>
                        <p><strong>الجنس:</strong> {{ $student->gender }}</p>
                        <p><strong>اسم الصف:</strong> {{ $student->class->school->name }}</p>
                        <p><strong>رقم الشعبة:</strong> {{ $student->class->name }}</p>
                        @foreach ($student->courses as $course)
                            @php
                                $totalPaid = $course->payments->sum('amount');
                                $remaining = $course->value_price - $totalPaid;
                                $badgeClass = $remaining == 0 ? 'badge-paid' : ($totalPaid > 0 ? 'badge-partial' : 'badge-unpaid');
                                $badgeText = $remaining == 0 ? 'مدفوع بالكامل' : ($totalPaid > 0 ? 'مدفوع جزئي' : 'لم يتم الدفع');
                            @endphp
                            <div class="card course-card mb-3">
                                <div class="card-header">
                                    <span>بيانات المالية للمادة: {{ $course->name }}</span>
                                    <span class="badge {{ $badgeClass }} float-right">{{ $badgeText }}</span>
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
                                            <p>لا توجد دفعات مسجلة لهذه المادة.</p>
                                        @else
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>المبلغ المدفوع</th>
                                                        <th>تاريخ الدفع</th>
                                                        <th>نمط الدفع</th>
                                                        <th>ملاحظات</th>
                                                        <th>المستخدم الذي أتم العملية</th>
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
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.getElementById('printPdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        let yPosition = 10;

        document.querySelectorAll('.student-card').forEach(studentCard => {
            doc.setFontSize(16);
            doc.text(`معلومات الطالب: ${studentCard.dataset.name}`, 10, yPosition);
            yPosition += 10;

            doc.setFontSize(12);
            doc.text(`الاسم: ${studentCard.querySelector('p:nth-child(1)').innerText.split(': ')[1]}`, 10, yPosition);
            yPosition += 10;
            doc.text(`الجنس: ${studentCard.querySelector('p:nth-child(2)').innerText.split(': ')[1]}`, 10, yPosition);
            yPosition += 10;
            doc.text(`اسم الصف: ${studentCard.querySelector('p:nth-child(3)').innerText.split(': ')[1]}`, 10, yPosition);
            yPosition += 10;
            doc.text(`رقم الشعبة: ${studentCard.querySelector('p:nth-child(4)').innerText.split(': ')[1]}`, 10, yPosition);
            yPosition += 10;

            studentCard.querySelectorAll('.course-card').forEach(courseCard => {
                doc.setFontSize(14);
                doc.text(`بيانات المالية للمادة: ${courseCard.querySelector('.card-header span:first-child').innerText.split(': ')[1]}`, 10, yPosition);
                yPosition += 10;

                doc.setFontSize(12);
                courseCard.querySelectorAll('.card-body p').forEach(p => {
                    doc.text(p.innerText, 10, yPosition);
                    yPosition += 10;
                });

                yPosition += 10; // Add some space before the next course
            });

            yPosition += 10; // Add some space before the next student
        });

        doc.save('students_data.pdf');
    });
</script>
@endsection
