<!DOCTYPE html>
<html lang="ar">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة علامات للطلاب</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        body {
            font-size: 16px;
            font-family: 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 20px;
        }

        h1 {
            color: #333;
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 18px;
        }

        button {
            background-color: #3490dc;
            color: #fff;
            padding: 15px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        select {
            padding: 15px;
            text-align: center;
            border: 2px solid #ddd;
            border-radius: 10px;
            width: 50%;
            padding: 6px;
            box-sizing: border-box;
            font-size: 18px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            font-family: Arial, sans-serif;
            font-size: 20px;
        }

        button {
            padding: 10px 20px;
            border: 1px solid #4CAF50;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        h3 {
            text-align: center;
            margin-top: 50px;
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
@extends('layouts.app')

@section('content')

<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-primary" role="alert">
        {{$message}}
    </div>
    @endif
</div>

<h3>صفحة علامات الطالب: {{$student->name}}</h3>

<form action="{{ route('addSubjectToAllStudents', ['student' => $student->id]) }}" method="post">
    @csrf
    <label for="subject">اختر المادة:</label>
    <select name="subject" id="subject" required dir="rtl">
        @foreach($subjects as $subject)
        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
        @endforeach
    </select>

    <label for="grade">العلامة:</label>
    <input type="text" name="grade" id="grade" required dir="rtl">

    <button  class="btn btn-info" type="submit">إضافة المادة للطلاب</button>
</form>

<!-- زر العودة إلى الصفحة السابقة -->
<a href="javascript:history.back()" class="btn btn-primary">رجوع</a>

<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>المادة</th>
            <th>العلامة</th>
            <th>إجراءات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($student->subjects as $subject)
        <tr>
            <td>{{ $subject->name }}</td>
            <td>{{ $subject->pivot->grade }}</td>
            <td>
                <form class="delete-form"
                    action="{{ route('deleteSubjectGrade', ['student' => $student->id, 'subject' => $subject->id]) }}"
                    method="post" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا المنتج؟')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">حذف العلامة</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
@endsection
