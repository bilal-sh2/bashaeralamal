@extends('layouts.index')

@section('content')
<style>
.a1, .a2 {
        text-decoration: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border: 0;
        font-size: 18px;
        padding: 10px 20px;
        display: inline-block;
        color: #fff;
        text-transform: uppercase;
        border-radius: 500px;
        font-weight: bold;
        font-family: Arial;
    }

    .a1 {
        background: linear-gradient(90deg, #0074cc, #0064b7, #0055a2, #00448d, #003379, #002364, #00124f, #00013a);
        background-size: 1800% 100%;
        -webkit-animation: rainbow 6s linear infinite;
        animation: rainbow 6s linear infinite;
    }

    .a2 {
        background: linear-gradient(90deg, #32CD32, #006400, #FFDEAD, #DAA520, #20AAB2, #ADFF2F, #7ca5de, #3e73bd);
        background-size: 1800% 100%;
        -webkit-animation: rainbow 10s linear infinite;
        animation: rainbow 10s linear infinite;
    }

    @-webkit-keyframes rainbow {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    @keyframes rainbow {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }
</style>

<div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-primary" role="alert">
                {{$message}}
            </div>
        @endif
    </div>


    <div class="col-sm">
                        </div>
                         <!-- الخلفية -->
    <div class="container">
<div class="col-xl-40 col-lg-7 col-md-6">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="d-flex align-items-end justify-content-center h-100"></div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <a href="javascript:void(0)" data-bs-target="#addRoleModal" data-bs-toggle="modal" class="stretched-link text-nowrap add-new-role">
                                    <span class="btn btn-primary mb-1">اضافة شعبة جديد</span>
                                </a>
                                <p class="mb-0">يمكنك من هنا اضافة شعبة جديد</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                </div>
            </div>
    
    <!-- زر إضافة مادة -->
   <!-- Role cards -->
   <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5 pb-5">
                        <div class="text-center mb-4">
                            <h1 class="role-title">اضافة شعبة جديد</h1>
                            <p>مرحبا بك </p>
                        </div>

                        <!-- Form to add a new course -->
                        <form action="{{ route('school_class.store')}}" method="POST" id="addCourseForm" class="row">
                            @csrf
                            <input type="text" class="form-control" id="num" name="school_id" style="display: none; " required value={{$id}}>

<div class="mb-3">
    <label for="name" class="form-label">أسم شعبة الجديد</label>
    <input type="text" class="form-control" id="name" name="name" required>
</div>



<div class="mb-3">
<label for="email" class="form-label">البريد الإلكتروني</label>
<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
</div>


<div class="mb-3">
<label for="password" class="form-label">كلمة السر</label>
<input type="password" class="form-control" id="password" name="password" required>
</div>


        <button type="submit" class="btn btn-primary">أضافة</button>
                        </form>
                        <!-- End of form -->
                    </div>
                </div>
            </div>
        </div>


<br>
    <div class="table-responsive">
    <table class="table table-bordered table-hover" name="myTable" id="myTable">
        <thead class="table-dark">
            <tr >
                <th scope="col">رقم الشعبة</th>
                <th scope="col">اسم الشعبة</th>
                <th scope="col">البريد</th>
                <th scope="col">كلمة المرور</th>

         
           
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
            @foreach($school->schoolclass as $item)
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



@endsection
