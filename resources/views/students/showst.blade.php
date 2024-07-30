

@extends('layouts.index')
@section('content')

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* التنسيق العام */
        body {
            font-size: 16px;
            font-family: 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 20px;
        }

        /* أسلوب الإدخال */
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 20px;
            box-sizing: border-box;
            font-size: 16px;
        }

        /* زر الحفظ */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin: 10px 0;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 18px;
        }

        /* تحسين زر الحفظ عند التحويم */
        button:hover {
            background-color: #45a049;
        }

        /* تحسين جدول البيانات */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: right;
        }

        /* الشعار */
        .logo {
            display: inline-block;
            margin-right: 10px;
        }

        /* زر الطباعة */
        .btn-print {
            display: block;
            width: 120px;
            margin: auto;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
        }

        /* تحسين زر الطباعة عند التحويم */
        .btn-print:hover {
            background-color: #0056b3;
        }

        /* إخفاء عناصر عند الطباعة */
        @media print {
            .date-print {
                display: none;
            }

            .url-print {
                display: none;
            }
        }
    </style>
</head>

<body id="body">
<a onclick="goBack()" role="button">رجوع للخلف</a>

    <div id="data">
        <div class="container">
            <a onclick='printPage()'><img src="{{ asset('Logo_mehad_baseline_en (1).png') }}" alt="" width="200px"></a>

            <h1>بيانات الطالب</h1>

            @if (session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('student.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h2>( {{ $student->name }} )</h2>

                <table>
                    <tr>
                        <th>رقم الطالب</th>
                        <td><input type="text" name="id" value="{{ $student->id }}" readonly></td>
                    </tr>

                    <tr>
                        <th>صورة شخصية للطالب</th>
                        <td>
                            @if ($student->image)
                                <img src="{{ asset('/' . $student->image) }}" alt="صورة الطالب">
                            @else
                                لا توجد صورة
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>الأسم</th>
                        <td><input type="text" name="name" value="{{ $student->name }}"></td>
                    </tr>

                    <tr>
                        <th>اسم المستخدم</th>
                        <td><input type="text" name="email" value="{{ $student->email }}" readonly></td>
                    </tr>

                    <tr>
                        <th>كلمة المرور</th>
                        <td><input type="text" name="password" value="{{ $student->password }}"></td>
                    </tr>

                    <tr>
                        <th>تاريخ الميلاد</th>
                        <td><input type="text" name="birthdate" value="{{ $student->birthdate }}"></td>
                    </tr>

                    <tr>
                        <th>الجنس</th>
                        <td><input type="text" name="gender" value="{{ $student->gender }}"></td>
                    </tr>

                    <tr>
                        <th>العنوان</th>
                        <td><input type="text" name="address" value="{{ $student->address }}"></td>
                    </tr>

                    <tr>
                        <th>رقم التواصل الأول</th>
                        <td><input type="text" name="parent_phone1" value="{{ $student->parent_phone1 }}"></td>
                    </tr>

                    <tr>
                        <th>رقم التواصل الاحتياطي</th>
                        <td><input type="text" name="parent_phone2" value="{{ $student->parent_phone2 }}"></td>
                    </tr>

                    <tr>
                        <th>الرسوم</th>
                        <td><input type="text" name="value_price" value="{{ $student->value_price }}"></td>
                    </tr>
                </table>
                <center>
                                   <button type="submit">حفظ التعديلات</button>
 
                </center>
            </form>

            <!-- جدول العلامات -->
            <h2>العلامات</h2>
            <table>
                <thead>
                    <tr>
                        <th>المادة</th>
                        <th>العلامة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->subjects as $subject)
                        <tr>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->pivot->grade }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- جدول الغيابات -->
            <h2>الغيابات</h2>
            <table>
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>السبب</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->absences as $absence)
                        <tr>
                            <td>{{ $absence->date }}</td>
                            <td>{{ $absence->reason }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- جدول الملاحظات -->
            <h2>الملاحظات</h2>
            <table>
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>الملاحظة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->notes as $note)
                        <tr>
                            <td>{{ $note->date }}</td>
                            <td>{{ $note->content }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <h2>الدفعات المالية</h2>
            <table>
                <thead>
                    <tr>
                        <th>الدفعة</th>
                        <th>تاريخ الدفعة</th>
                        <th>ملاحظات</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->payments as $payment)
                        <tr>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->payment_date }}</td>
                            <td>{{ $payment->notes }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <!-- زر الطباعة -->
    <div class="btn-print" onclick="printPage()">طباعة</div>

    <script>
        // دالة لطباعة الصفحة
        function printPage() {
            var bodyContent = document.getElementById('body').innerHTML;
            var dataContent = document.getElementById('data').innerHTML;
            document.getElementById('body').innerHTML = dataContent;
            window.print();
            document.getElementById('body').innerHTML = bodyContent;
        }
    </script>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>

</html>

@endsection
