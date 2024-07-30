@extends('layouts.index')
@section('content')
<style>
    
.table-responsive .table tbody tr td {
    font-size: 22px; /* حجم الخط الذي تريده */
}

    /* تكبير حجم الخط */
    table#myTable {
        font-size: 18px; /* حجم الخط المطلوب */
    }

    /* اختياري: تكبير حجم الخط في العناوين (thead) */
    table#myTable thead th {
        font-size: 20px; /* حجم الخط المطلوب */
    }

    /* اختياري: تكبير حجم الخط في الأزرار */
    .btn {
        font-size: 16px; /* حجم الخط المطلوب */
    }
</style>    

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
                                    <span class="btn btn-primary mb-1">اضافة صف جديد</span>
                                </a>
                                <p class="mb-0">يمكنك من هنا اضافة صف جديد</p>
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
                            <h1 class="role-title">اضافة صف جديد</h1>
                            <p>مرحبا بك </p>
                        </div>

                        <!-- Form to add a new course -->
                        <form action="{{ route('school.store') }}" method="POST" id="addCourseForm" class="row">
                            @csrf
                            <div class="mb-3">


<label for="name" class="form-label">نظام المحاسبة للصف</label>
<select name="aco" class="form-select" required dir="ltr">
                    <option value=" " selected> </option>
                    <option value="مادة">مادة</option>
                    <option value="فصلي">فصلي</option>
                </select>                
            </div>


<div class="mb-3">
<label for="name" class="form-label">أسم الصف الجديد</label>
<input type="text" class="form-control" id="name" name="name" required>
</div>
<div class="mb-3">
<label for="major" class="form-label">ملاحظات</label>
<input type="text" class="form-control"name="type" id="type" namtypee="type" required>
</div>
        <button type="submit" class="btn btn-primary">أضافة</button>
                        </form>
                        <!-- End of form -->
                    </div>
                </div>
            </div>
        </div>


<div class="table-responsive">
<table class="table table-bordered table-hover" name="myTable" id="myTable">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">الرقم</th>
                        <th scope="col">اسم الصف</th>
                        <th scope="col">ملاحظات</th>
                        <th scope="col">تعديل</th>
                        <th scope="col">حذف الصف</th>
                        <th scope="col">اعدادات الصف </th>
                        <th scope="col">عرض طلاب الصف </th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp

                    @if(isset($schools))
                    @foreach ($schools as $item)
                    <tr>
                        <td><p style="color: black;">{{$i++}}</p></td>
                        <td>
                            <form action="{{ route('school.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <input style="width: 100%; text-align: center; font-size: 25px; border: none;" type="text" class="form-control" name="name" id="name-{{ $item->id }}" value="{{ $item->name }}" disabled>
                                </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="text-align: center; font-size: 25px; border: none;" type="text" class="form-control" name="type" id="type-{{ $item->id }}" value="{{ $item->type }}" disabled>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-warning" onclick="enableEdit({{ $item->id }})">تمكين التعديل</button>
                            <button type="submit" class="btn btn-outline-success" style="display: inline-block;">حفظ التعديلات</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('school.destroy',$item->id ) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذه الفئة مع البيانات التي فيها')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">حذف</button>
                            </form>
                        </td>
                        <td>
                            <div class="col-sm">
                                <a class="btn btn-outline-secondary" href="{{ route('school.show' ,$item->id )}}">إعدادات</a>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('student_school.index_school',$item->id) }}" class="btn btn-outline-primary"><i class="fa fa-search me-2"></i>عرض جميع الطلاب</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            </div>
    </div>
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

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="/DataTables/datatables.css" />
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

    <script>

        // };
        function filterCategories() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("categorySearch");
                filter = input.value.toUpperCase();
                table = document.querySelector("table");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1]; // تم تعديل هذا الجزء ليناسب البحث حسب الاسم
                    if (td) {
                        txtValue = td.getElementsByTagName("input")[2].value; // تم تعديل هذا الجزء للحصول على القيمة المدخلة
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }



        function enableEdit(rowId) {
            var nameInput = document.getElementById('name-' + rowId);
            var locinput = document.getElementById('type-' + rowId);
            nameInput.disabled = false;
            locinput.disabled = false;
        }

        function printPage() {
            window.print();
        }
    </script>
@endsection