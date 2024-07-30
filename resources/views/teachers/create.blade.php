<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> صفحة إضافة معلم جديد </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
        crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style1.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-size: 16px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            height: 40px;
            margin-bottom: 15px;
            padding: 8px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .btn-primary {
            width: 100%;
            height: 40px;
            font-size: 16px;
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        a {
            display: block;
            margin-bottom: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        </h1>

        <a class="btn btn-primary" href="{{ route('school.show', $id) }}">رجوع</a>
        <h1> أضافة معلم جديد</h1>
        <form action="{{ route('teacher.store')}}" method="POST">
            @csrf
            <input type="text" class="form-control" id="num" name="school_id" style="display: none; " required
                value={{$id}}>
                
            <div class="mb-3">
                <label for="name" class="form-label">أسم المعلم الجديد</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="Accuracy" class="form-label">نوع الشهادة</label>
                <input type="text" class="form-control" id="Accuracy" name="Accuracy">
            </div>

            <div class="mb-3">
                <label for="birthdate" class="form-label">تاريخ الميلاد</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate">
            </div>

            <div class="mb-3">
                <label for="adress" class="form-label">العنوان</label>
                <input type="text" class="form-control" id="adress" name="adress">
            </div>

            <div class="mb-3">
                <label for="parent_phone1" class="form-label">رقم التواصل الأول</label>
                <input type="text" class="form-control" id="parent_phone1" name="parent_phone1">
            </div>

            <div class="mb-3">
                <label for="parent_phone2" class="form-label">رقم التواصل الثاني</label>
                <input type="text" class="form-control" id="parent_phone2" name="parent_phone2">
            </div>

            <button type="submit" class="btn btn-primary">أضافة</button>
        </form>
    </div>

  
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>
