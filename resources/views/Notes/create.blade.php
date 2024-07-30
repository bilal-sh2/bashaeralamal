<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة ملاحظة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-primary" role="alert">
                {{$message}}
            </div>
        @endif
    </div>

    <div class="container">
        <h1 class="mt-5">إضافة ملاحظة للطالب</h1>
        <form action="{{ route('notess.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" class="form-control" id="student_id" name="student_id" value="{{ $id }}"  style="display: none;" readonly>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">نوع الملاحظة</label>
                <input type="text" class="form-control" id="type" name="type">
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">الملاحظات</label>
                <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">إرسال</button>
            <button type="button" class="btn btn-secondary" onclick="goBack()">رجوع</button>
        </form>
    </div>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
