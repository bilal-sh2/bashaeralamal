@extends('layouts.index')

@section('content')

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

            <a href="{{ route('class_files_index.index', ['id' => $id]) }}" class="btn btn-outline-primary">عرض الملفات</a>
      
            <a href="{{ route('class_file.create', ['id' => $id]) }}" class="btn btn-outline-success">إضافة ملفات</a>

            <a href="{{ route('student.create', ['id' => $id]) }}" class="btn btn-outline-secondary">إضافة طالب</a>

            <a href="{{ route('item_create.create', ['id' => $id]) }}" class="btn btn-outline-success">إضافة جدول داوم</a>
            <a href="{{ route('item_index.index', ['id' => $id]) }}" class="btn btn-outline-primary">عرض  جدول الدوام </a>


            <a class="btn btn-outline-danger" onclick="enableEdit()">تمكين</a>
 
            <button class="btn btn-outline-dark" onclick="ExportToExcel('xlsx')">Export Data To Excel</button>
</nav>
              

<!-- 
                <a class="navbar-brand" href="{{ url('/a') }}">
      ا               </a> -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">{{'الصفحة الرئيسية' }}</a>
                        </li>
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('تسجيل الدخول') }}</a>
                                </li>
                            @endif
                            
                           
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>




<div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-primary" role="alert">
                {{$message}}
            </div>
        @endif
    </div>


    <div class="container">
        @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
        @endif
    </div>




    <div class="table-responsive">
    <table class="table table-bordered table-hover" name="myTable" id="myTable">
        <thead class="table-dark">
            <tr >
            <th scope="col">رقم الطالب </th>

            <th scope="col">صورة الشخصية للطالب </th>

                <th scope="col">اسم الطالب </th>
                <th scope="col">اسم المستخدم</th>
                <th scope="col">كلمة المرور</th>

                <th scope="col">تاريخ الميلاد</th>
                <th scope="col">الجنس</th>

                <th scope="col">العنوان  </th>
                
                <th scope="col">رقم التواصل الاول</th>
               
                <th scope="col">رقم التواصل الاحتياطي</th>
                <th scope="col">الرسوم</th>

                <th scope="col">لحفظ التعديلات</th>
                <th scope="col">سجل رسوم الطالب</th>

                <th scope="col">سجل رسوم الطالب</th>
                <th scope="col">علامات</th>
                <th scope="col">غيابات</th>
                <th scope="col">ملاحظات</th>

                <th scope="col">عرض بيانات </th>

           </tr>
        </thead>
        <tbody>
            
            @foreach ($students as $item)
            <tr >
                <td>{{$item->id}}</td>
                <td>
        @if ($item->image)
            <img src="{{ asset('/' . $item->image) }}" alt="Student Image" style="width: 100px; height: 100px;">
        @else
            No Image
        @endif
    </td>
                <td>
                    <form action="{{ route('student.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <input style="width: 200px;" type="text" class="form-control" name="name" id="name-{{ $item->id }}" value="{{ $item->name }}" disabled>
                        </div>
                </td>

                <td>
                    <div class="form-group">
                        <input style="width: 200px;" type="email" class="form-control" name="email" id="email-{{ $item->id }}" value="{{ $item->email }}"disabled >
                    </div>
                </td>


                <td>
                    <div class="form-group">
                        <input style="width: 130px;" type="text" class="form-control" name="password" id="password-{{ $item->id }}" value="{{ $item->password }}"disabled >
                    </div>
                </td>

                
                             <td>
                    <div class="form-group">
                        <input style="width: 200px;" type="date" class="form-control" name="birthdate" id="birthdate-{{ $item->id }}" value="{{ $item->birthdate }}" disabled>
                    </div>
                </td>

                <td>
                    <div class="form-group">
                        <input style="width: 200px;" type="text" class="form-control" name="gender" id="gender-{{ $item->id }}" value="{{ $item->gender }}" disabled>
                    </div>
                </td>

                
                <td>
                    <div class="form-group">
                        <input style="width: 100px;" type="text" class="form-control" name="address" id="address-{{ $item->id }}" value="{{ $item->address }}" disabled>
                    </div>
                </td>
            
                <td>
                    <div class="form-group">
                        <input style="width: 130px;" type="text" class="form-control" name="parent_phone1" id="parent_phone1-{{ $item->id }}" value="{{ $item->parent_phone1 }}" disabled>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input style="width: 130px;" type="text" class="form-control" name="parent_phone2" id="parent_phone2-{{ $item->id }}" value="{{ $item->parent_phone2 }}" disabled>
                    </div>
                </td>

                <td>
                    <div class="form-group">
                        <input style="width: 130px;" type="text" class="form-control" name="value_price" id="parent_phone2-{{ $item->id }}" value="{{ $item->value_price }}" disabled>
                    </div>
                </td>

              
                <td>
                    <button type="submit" class="btn btn-outline-secondary" style="display: inline-block;">حفظ</button>
                </td>



                </form>


                <td>
                <a class="btn btn-outline-success" href="{{ route('student_payments.create',$item->id) }}">اضافة</a>
                </td>


                <td>
        <form action="{{ route('student.destroy',$item->id ) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا الطالب')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger">حذف</button>
</form>
                </td>
                <td>
        <a  class="btn btn-outline-warning" href="{{ route('student.show',$item->id )}}">أضافة </a>
                </td>
                <td>
                <a class="btn btn-outline-success" href="{{ route('add_absenceC.create', ['item_id' => $item->id, 'class_id' => $id]) }}">أضافة</a>

                </td>


                <td>
                <a class="btn btn-outline-info"href="{{ route('notes.create',$item->id )}}" >أضافة</a>

                </td>


                <td>
                <a href="{{ route('student.showall',['item_id' => $item->id, 'class_id' => $id]) }}" class="btn btn-outline-primary">عرض</a>

                </td>
            </tr>
    
            @endforeach
    </table>        </div>
    <h5 class="w"> <div id="result"></div></h5>
    <br>
    <h5 class="e"> <div id="result2"></div></h5>
</div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.2/css/buttons.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.0.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.2/js/buttons.colVis.min.js"></script>


<script src="/DataTables/datatables.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.3/js/dataTables.min.js "></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script src="{{ asset('https://code.jquery.com/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
<script>
      let table = new DataTable('#myTable', {
    searching: true,
    lengthMenu: [[5,10, 25, 50, 100, -1], ['5','10', '25', '50', '100', 'عرض الكل']],

    columnDefs: [
        { width: '100px', targets: 0 }, // تحديد عرض العمود الأول بـ 100 بكسل
        { width: '150px', targets: 1 }, // تحديد عرض العمود الثاني بـ 150 بكسل
        // تكملة تعريف عرض الأعمدة الباقية حسب الحاجة
    ],
  });

</script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<script>
    function ExportToExcel(type, fn, dl) {
        var table = document.getElementById('myTable');
        var data = [];
        var headers = [];

        // Get table headers
        for (var i = 0; i < table.rows[0].cells.length; i++) {
            headers[i] = table.rows[0].cells[i].innerHTML;
        }

        // Add headers to data
        data.push(headers);

        // Get table data
        for (var i = 1; i < table.rows.length; i++) {
            var row = table.rows[i];
            var rowData = [];
            for (var j = 0; j < row.cells.length; j++) {
                rowData[j] = row.cells[j].innerHTML;
            }
            data.push(rowData);
        }

        // Create worksheet and workbook
        var ws = XLSX.utils.aoa_to_sheet(data);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

        // Download or save file
        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
            XLSX.writeFile(wb, fn || ('NagehSheet.' + (type || 'xlsx')));
    }
</script>

<script>


document.addEventListener('DOMContentLoaded', function() {
    var allQuantityFields = document.querySelectorAll('table tbody input[id^="quantity"]');
    allQuantityFields.forEach(function(field) {
        if (field.value < 10) {
            field.style.backgroundColor = 'rgba(255, 0, 0, 0.3)'; // أحمر كاشف
        }
    });
});


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

function enableEdit(rowId) {
    var fields = document.querySelectorAll('input[type="text"]');
    fields.forEach(function(field) {
        field.disabled = false;
    });
}
</script>



@endsection
