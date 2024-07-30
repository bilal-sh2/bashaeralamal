<!-- resources/views/class_files/index.blade.php -->

@extends('layouts.index')

@section('content')
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الملفات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .table {
            background-color: #fff;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
    <a class="btn btn-primary" href="{{ route('school_class.show',$class_id )}}">رجوع</a>

    <div class="container">
        <h1 class="mt-5">قائمة جدول الصف</h1>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">صورة</th>
                    <th scope="col">اسم الملف</th>
                    <th scope="col">الصف المرتبط</th>
                    <th scope="col">عرض</th>
                    <th scope="col">حذف</th> <!-- إضافة عمود للحذف -->

                </tr>
            </thead>
            <tbody>
                @foreach ($items as $file)
                <tr>
                    <th scope="row">{{ $file->id }}</th>
                    <td><img src="{{ asset('storage/' . $file->image) }}" alt="صورة" style="max-width: 100px;"></td>
                    <td>{{ $file->title }}</td>
                    <td>{{ $file->schoolClass->name }}</td>
                    <td><a href="{{ asset('storage/' . $file->image) }}" target="_blank">عرض الملف</a></td>           <td>
                <form action="{{ route('item.destroy', $file->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </td>
                </tr>
     
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
@endsection
