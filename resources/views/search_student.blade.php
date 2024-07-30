@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض بيانات الطالب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
            margin-bottom: 30px;
        }
        h2 {
            color: #28a745;
            margin-top: 20px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
        }
    </style>
    
</head>

<body>
    
    <div class="container">
        <h1>البحث عن الطالب</h1>
        <form action="{{ route('student.search') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="student_id" placeholder="ابحث عن الطالب ..." aria-label="ابحث عن الطالب" aria-describedby="basic-addon2">
                <button class="btn btn-outline-secondary" type="submit">ابحث</button>
            </div>
        </form>
        
        @if(isset($student))
        <h2>بيانات الطالب</h2>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>الاسم:</th>
                    <td>{{ $student->name }}</td>
                </tr>
                <tr>
                    <th>الصف:</th>
                    <td>{{ $student->schoolClass->name }}</td> <!-- هنا يتم جلب اسم الصف -->
                </tr>
                <!-- يمكنك إضافة المزيد من الحقول هنا -->
            </tbody>
        </table>
        
        <!-- جدول العلامات -->
        <h2>العلامات</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>المادة</th>
                    <th>العلامة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student->subjects as $subject)
                <tr>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->pivot->grade }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- جدول الغيابات -->
        <h2>الغيابات</h2>
        <table class="table table-striped">
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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>الملاحظة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student->notes as $note)
                <tr>
                    <td>{{ $note->date }}</td>
                    <td>{{ $note->content }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <div class="alert alert-danger" role="alert">
            الطالب غير موجود.
        </div>
        <!-- زر الرجوع -->
        @endif
    </div>

    <!-- إضافة السكربت -->
    <script>
        function goBack() {
            window.history.go(-1);
        }
    </script>
</body>
</html>
@endsection
