
@extends('layouts.index')
@section('content')

<style>
    .table-responsive .table tbody tr td {
    font-size: 25px; /* حجم الخط الذي تريده */
}
    .filters-container {
        margin-bottom: 20px;
        text-align: center;
    }

    .filters-container input[type="text"],
    .filters-container select {
        margin-right: 10px;
        width: 200px;
        padding: 6px 12px;
        font-size: 16px;
    }

    .filters-container button {
        margin-right: 10px;
        padding: 8px 12px;
        font-size: 16px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    .filters-container button#clearFiltersButton {
        background-color: #dc3545;
    }

    .export-button {
        margin-top: 10px;
        padding: 8px 16px;
        font-size: 16px;
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>

<div class="filters-container">
<h1>صفحة الطلاب من المرحلة الإبتدائية الى صف الثامن الاعدادي </h1>

    <br>

    <input type="text" id="Searchname" placeholder="ابحث عن اسم الطالب...">
    <button id="Searchnamebutton">بحث</button>

    <input type="text" id="Searchschool" placeholder="ابحث عن مدرسة ...">
    <button id="Searchschoolbutton">بحث</button>

    <input type="text" id="Searchclass" placeholder="ابحث عن صف  ...">
    <button id="Searchclassbutton">بحث</button>

    <br>



    <button id="clearFiltersButton">إزالة التصفيات</button>


    <button class="export-button" onclick="ExportToExcel('xlsx')">Export Data To Excel</button>
</div>


<div class="table-responsive">
    <table class="table table-bordered table-hover" name="myTable" id="myTable">
        <thead class="table-dark">
 
            <tr>      
                
            <th>صف الطالب</th>
                <th>شعبة الطالب</th>
                <th>اسم الطالب</th>
                <th>الجنس</th>

         

                <th>اضافة</th>
                <th>عرض</th>

       

   
            </tr>
        </thead>
        <tbody>
        @foreach ($students as $item)

    
       

    
        <tr>       
            
        <td>{{ $item->class->school->name }}</td>
        <td>{{ $item->class->name }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->gender }}</td>
>
   
        <td>
        <a class="btn btn-outline-success" href="{{ route('student_payments.create',$item->id) }}">اضافة</a>


<td>
<a class="btn btn-outline-danger" href="{{ route('student_payments.show',$item->id) }}">عرض</a>

        </td> <!-- زر الحذف -->

</tr>
    </tr>
@endforeach

        </tbody>
        </table>

        </div>

      </div>
    </main>
  </div>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

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
$(document).ready(function() {
    $('.js-example-basic-single').select2();
    
});
$(document).ready(function() {
    $('.js-example-basic-single2').select2();
    
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
  
  let table = new DataTable('#myTable', {
    searching: true,
    lengthMenu: [[5,10, 25, 50, 100, -1], ['5','10', '25', '50', '100', 'عرض الكل']],

    columnDefs: [
        { width: '100px', targets: 0 }, // تحديد عرض العمود الأول بـ 100 بكسل
        { width: '150px', targets: 1 }, // تحديد عرض العمود الثاني بـ 150 بكسل
        // تكملة تعريف عرض الأعمدة الباقية حسب الحاجة
    ],
  });




$('#Searchschoolbutton').on('click', function() {
    let searchText = $('#Searchschool').val();
    table.column(0).search(searchText).draw();
});

$('#Searchclassbutton').on('click', function() {
    let searchText = $('#Searchclass').val();
    table.column(1).search(searchText).draw();
});

$('#Searchnamebutton').on('click', function() {
    let searchText = $('#Searchname').val();
    table.column(2).search(searchText).draw();
});


$('#value_pricebutton').on('click', function() {
    let searchText = $('#value_price').val();
    table.column(9).search(searchText).draw();
});




$('#clearFiltersButton').on('click', function() {
    // إزالة التصفيات من كل الأعمدة
    table.columns().search('').draw();
    
    // إعادة تعيين قيم حقول البحث
    $('#nameSearchInput').val('');
    $('#lastnameSearchInput').val('');
    $('#namefSearchInput').val('');


});
// بعد إجراء عملية البحث أو التصفية، قم بتحديث عدد الصفوف المرشحة
table.on('draw', function () {
    let filteredRows = table.rows({ search: 'applied' }).count();
    let totalRows = table.rows().count();
    $('#filteredRowCount').text(filteredRows);
    $('#totalRowCount').text(totalRows);
});





// باقي الأكواد للت


// باقي الأكواد للتصفية الأخرى

// باقي الأكواد للتصفية الأخرى


    </script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // احتفظ بمرجع لحقول اختيار التواريخ
  var startDateField = document.getElementById('startDate');
  var endDateField = document.getElementById('endDate');

  // استمع لتغييرات في حقول اختيار التواريخ
  startDateField.addEventListener('change', filterTableByDateRange);
  endDateField.addEventListener('change', filterTableByDateRange);

  function filterTableByDateRange() {
    var table = document.getElementById('myTable');
    var rows = table.getElementsByTagName('tr');

    var startDate = startDateField.value;
    var endDate = endDateField.value;

    // الحلق عبر الصفوف للتحقق من التاريخ وإظهار/إخفاء الصفوف بناءً على الفلترة
    for (var i = 0; i < rows.length; i++) {
      var cells = rows[i].getElementsByTagName('td');
      if (cells.length > 0) {
        var visitDate = cells[4].innerText; // العمود الثاني يحتوي على تاريخ الزيارة

        // قارن التاريخ مع نطاق التواريخ المحدد
        if ((startDate === '' || endDate === '') ||
            (visitDate >= startDate && visitDate <= endDate)) {
          rows[i].style.display = ''; // إظهار الصف إذا كان التاريخ ضمن النطاق المحدد
        } else {
          rows[i].style.display = 'none'; // إخفاء الصف إذا كان التاريخ خارج النطاق المحدد
        }
      }
    }
  }
});
</script>

@endsection
