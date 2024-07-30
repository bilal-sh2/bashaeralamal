<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style1.css">
<script src="script.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <style>
          body::before {
    content: "";
    background-image: url('لوغو دار حفص القراءة والتجويد نهااائي.png');
    background-attachment: fixed;
    background-position: center bottom; /* توضيح موقع الصورة في الوسط الأفقي وأسفل العمودي */
    background-size: cover;
    opacity: 0.1; /* تعديل شفافية الصورة */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1; /* تأكد من أن الصورة خلفية */
}.logo-container {
    float: left;
}
        body {
            font-size: 16px;

            font-family: 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 20px;
        }

        table {
        border-collapse: collapse;
        width: 100%;
    }
    th{
        font-size: 18px; /* تعيين حجم الخط الذي ترغب به */
    }

    table, th, td ,select{
        border: 
        border-radius: 10px;
    }
    

    th, td ,select{
        padding: 15px;
        text-align: center;
    }

    input[type="text"] {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    button {
        padding: 10px 20px;
        border: 1px solid #4CAF50;
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }

    button:disabled {
        background-color: #ddd;
        color: #666;
        border: 1px solid #666;
        cursor: not-allowed;
    }

        select {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
            font-size: 18px; /* تعيين حجم الخط الذي ترغب به */

        }

    /* تخصيص مظهر حقل الاختيار كرايديو بطن */


    label {
        display: inline-block;
        margin: 5px;
        padding: 10px;
        border: 2px solid #4CAF50;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;

    }


    input[type="radio"]:checked + label {
        size: 15px;
        background-color: #4CAF50;
        color: white;
    }
    h2 {
        font-family: 'Arial', sans-serif; /* اختر الخط الذي تفضله */
        color: #4CAF50; /* اختر لون الخط الذي يتناسب مع تصميمك */
        text-align: center; /* توسيط النص */
        padding: 20px; /* إضافة تباعد داخلي لجعله أجمل */
        border-radius: 10px; /* إضافة زوايا مستديرة */
        background-color: #f2f2f2; /* إضافة لون خلفية للخلفية */
    }
    
    #diagnosisInput {
            width: 300px;
        }
</style>

@extends('layouts.app')

@section('content')



<div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-primary" role="alert">
                {{$message}}
            </div>
        @endif
    </div>


<center> 
  <a  class="btn btn-primary" href="{{ route('school.show' ,$id )}}">رجوع</a>
<input type="text" id="categorySearch" oninput="filterCategories()" placeholder="ابحث عن الصف ...">  
</center>

<div class="body">
    <div class="container">


    <table class="table table-bordered table-hover" >
 
        <thead class="thead-dark">
            <tr >
                <th scope="col">رقم الصف</th>
                <th scope="col">أسم الصف</th>
                <th scope="col">اسم المستخدم</th>
                <th scope="col">كلمة المرور</th>
                <th scope="col">أسم المعلم</th>

         
           
                <th scope="col">تعديل</th>
                <th scope="col">لحفظ التعديلات</th>
                <th scope="col">لحذف المنتج</th>
                <th scope="col">الدخول</th>

            </tr>
        </thead>
        <tbody>
            @php
            $i=1;
            @endphp
            @foreach ($schoolClasses as $item)
            <tr >
                <td>{{$i++}}</td>
                <td>
                    <form action="{{ route('school_class.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <input style="width: 200px;" type="text" class="form-control" name="name" id="name-{{ $item->id }}" value="{{ $item->name }}" disabled>
                        </div>
                </td>     <td>
                        <div class="form-group">
                            <input style="width: 200px;" type="text" class="form-control" name="email" id="email-{{ $item->id }}" value="{{ $item->email }}" >
                        </div>
                        </td>
                        <td>
                        <div class="form-group">
                            <input style="width: 200px;" type="text" class="form-control" name="password" id="password-{{ $item->id }}" value="{{ $item->password }}" >
                        </div>
                        </td>

                    </div>
                </td>
                            <td>
                <p>{{ $item->teacher->name }}</p>
                </td>
                <td>
                    <button type="button" class="btn btn-secondary" onclick="enableEdit({{ $item->id }})">تمكين</button>
                </td>
                <td>
                    <button type="submit" class="btn btn btn-success" style="display: inline-block;">حفظ</button>
                </td>
                </form>
                <td>
        <form action="{{ route('school_class.destroy',$item->id ) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا المنتج؟')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">حذف</button>
</form>
                </td>
        <td>
        <a  class="btn btn-primary" href="{{ route('school_class.show',$item->id )}}">الدخول للصف</a>
                </td>
          </tr>
    
  
            @endforeach
    </table>
    <h5 class="w"> <div id="result"></div></h5>
    <br>
    <h5 class="e"> <div id="result2"></div></h5>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    var allQuantityFields = document.querySelectorAll('table tbody input[id^="quantity"]');
    allQuantityFields.forEach(function(field) {
        if (field.value < 10) {
            field.style.backgroundColor = 'rgba(255, 0, 0, 0.3)'; // أحمر كاشف
        }
    });
});

function enableEdit(rowId) {
    var nameInput = document.getElementById('name-' + rowId);
    var descInput = document.getElementById('description-' + rowId);
    var d2escInput = document.getElementById('price-' + rowId);
    var d2es2cInput = document.getElementById('price2-' + rowId);
    var d3escInput = document.getElementById('quantity-' + rowId);

    nameInput.disabled = false;
    descInput.disabled = false;
    d2escInput.disabled = false;
    d3escInput.disabled = false;
    d2es2cInput.disabled = false;
    d3escInput.addEventListener('input', function() {
        if (d3escInput.value < 10) {
            d3escInput.style.backgroundColor = 'rgba(255, 0, 0, 0.3)';
        } else {
            d3escInput.style.backgroundColor = '';
        }
    });
}
function checkPriceLength(input) {
    if (input.value.length > 6) {
        input.value = input.value.slice(0, 6);
    }
}


    function filterCategories() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("categorySearch");
        filter = input.value.toUpperCase();
        table = document.querySelector("idd");
        tr = idd.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // تم تحديث الفهرس ليستهدف العمود الصحيح
            if (td) {
                txtValue = td.getElementsByTagName("input")[2].value; // تم تحديث هذا الفهرس للحصول على القيمة المناسبة
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    
</script>


