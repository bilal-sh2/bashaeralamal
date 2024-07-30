<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض بيانات الطالب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            direction: rtl;
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
        }

        h2 {
            color: #2980b9;
            margin-top: 20px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ecf0f1;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        td {
            background-color: #ecf0f1;
            color: #2c3e50;
        }

        .back-button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto 20px;
            text-align: center;
        }

        .back-button:hover {
            background-color: #2980b9;
        }

        .delete-btn {
            margin-left: 10px;
        }

        .delete-btn:hover {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="{{ route('school_class.show',$class_id )}}" class="back-button">رجوع للخلف</a>
        <h1>{{ $student->name }}</h1>
        <div class="row">
            <div class="col-md-6">
                <h2>بيانات الطالب</h2>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="color: black">الصف:</th>
                            <td>{{ $student->schoolClass->name }}</td>
                        </tr>
                        <tr>
                            <th style="color: black">تاريخ الميلاد:</th>
                            <td>{{ $student->birthdate }}</td>
                        </tr>
                        <tr>
                            <th style="color: black">العنوان:</th>
                            <td>{{ $student->address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h2>المواد والعلامات</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="color: black">المادة</th>
                            <th style="color: black">العلامة</th>
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
                <h2>الغيابات</h2>
                <ul>
                  

                   
                    @foreach ($student->absences as $absence)
                    <li>  <table><td>
{{ $absence->date }} - {{ $absence->reason }}
                    </td>
                        <form action="{{ route('absences.destroy', $absence->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                          <td>
                            <button type="submit" class="btn btn-danger btn-sm delete-btn">حذف</button>
                          </td>  
                        </form>
                    </li>
                    @endforeach
                </ul> </table>
                <h2>الملاحظات</h2>
                <ul>


              
                    @foreach ($student->notes as $note)
                    <li><table> <td>
                        {{ $note->type }} : {{ $note->notes }}
                    </td>  
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                          <td>
                            <button type="submit" class="btn btn-danger btn-sm delete-btn">حذف</button>
                          </td>  
                        </form>
                    </li>
                    @endforeach  </table>
                </ul>



                <h2>الدفعات المالية للطالب</h2>
                <ul>
           
                    @foreach ($student->payments as $payment)
                    <li>
                     <table>
                       
                             <td>{{ $payment->amount }}</td>
                    
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->notes }}</td>  
                    
                    <form action="{{ route('student_payments.destroy', $payment->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                        <td>
                           <button type="submit" class="btn btn-danger btn-sm delete-btn">حذف</button>  
                        </td>   
                        </table>
                   
                    

                 
                        </form>
                    </li>
                    @endforeach
                </ul>


            </div>
        </div>
    </div>
</body>

</html>
