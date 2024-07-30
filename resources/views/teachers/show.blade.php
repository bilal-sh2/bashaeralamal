<!-- resources/views/teachers/show.blade.php -->
@extends('layouts.index')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container">
    <div class="col-xl-12 col-lg-7 col-md-6">
        <div class="card">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-body text-center">
                        <a href="javascript:void(0)" data-bs-target="#addGroupModal" data-bs-toggle="modal" class="btn btn-primary mb-1">
                            اضافة مجموعة جديدة
                        </a>
                        <p class="mb-0">يمكنك من هنا اضافة مجموعة جديدة للمعلم</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Teacher Information -->
    <h1>بيانات المعلم</h1>
    <div>
        <strong>أسم المعلم:</strong> {{ $teacher->name }}
    </div>
    <div>
        <strong>الايميل:</strong> {{ $teacher->email }}
    </div>
    
    <!-- Group Information -->
    <div>
        <h2>بيانات المجموعة</h2>
        @if($teacher->groups->isEmpty())
            <p>No groups assigned.</p>
        @else
            @foreach($teacher->groups as $group)
                <div class="group-section">
                    <div class="group-header">
                        <h3>اسم المجموعة: {{ $group->name }}</h3>
                        <h4>اسم المادة: {{ $group->name_course }}</h4>
                        <div class="action-buttons">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editGroupModal{{ $group->id }}">تعديل المجموعة</button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteGroupModal{{ $group->id }}">حذف المجموعة</button>
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addStudentModal{{ $group->id }}">إضافة طالب</button>
                        </div>
                    </div>
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>اسم الطالب</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group->students as $student)
                                <tr>
                                    <td>{{ $student->student_name }}</td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $student->id }}">تعديل</button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStudentModal{{ $student->id }}">حذف</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Edit Group Modal -->
                <div class="modal fade" id="editGroupModal{{ $group->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5 pb-5">
                                <div class="text-center mb-4">
                                    <h1 class="group-title">تعديل المجموعة</h1>
                                </div>
                                <form action="{{ route('groups.update', $group->id) }}" method="POST" id="editGroupForm{{ $group->id }}" class="row">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">اسم المجموعة</label>
                                        <input type="text" name="name" class="form-control" id="name" value="{{ $group->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name_course">اسم المادة</label>
                                        <input type="text" name="name_course" class="form-control" id="name_course" value="{{ $group->name_course }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">تعديل</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Group Modal -->
                <div class="modal fade" id="deleteGroupModal{{ $group->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5 pb-5 text-center">
                                <h1 class="group-title">حذف المجموعة</h1>
                                <p>هل أنت متأكد أنك تريد حذف هذه المجموعة؟</p>
                                <form action="{{ route('groups.destroy', $group->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Student Modal -->
                @foreach($group->students as $student)
                <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5 pb-5">
                                <div class="text-center mb-4">
                                    <h1 class="student-title">تعديل الطالب</h1>
                                </div>
                                <form action="{{ route('students_in_groups.update', $student->id) }}" method="POST" id="editStudentForm{{ $student->id }}" class="row">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="student_name">اسم الطالب</label>
                                        <input type="text" name="student_name" class="form-control" id="student_name" value="{{ $student->student_name }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">تعديل</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Student Modal -->
                <div class="modal fade" id="deleteStudentModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5 pb-5 text-center">
                                <h1 class="student-title">حذف الطالب</h1>
                                <p>هل أنت متأكد أنك تريد حذف هذا الطالب؟</p>
                                <form action="{{ route('students_in_groups.destroy', $student->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforeach
        @endif
    </div>
    
    <a href="{{ route('teachers.index') }}" class="btn btn-primary">Back</a>
</div>

<!-- Add Group Modal -->
<div class="modal fade" id="addGroupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-group">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5 pb-5">
                <div class="text-center mb-4">
                    <h1 class="group-title">إضافة مجموعة جديدة</h1>
                </div>

                <!-- Form to add a new group -->
                <form action="{{ route('groups.store') }}" method="POST" id="addGroupForm" class="row">
                    @csrf
                    <div class="form-group">
                        <label for="name">اسم المجموعة</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>

                 
                        <div class="form-group">
                        <label for="name_course">اسم المادة</label>
                        <input type="text" name="name_course" class="form-control" id="name_course" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="teacher_id">رقم المعلم</label>
                        <input type="text" name="teacher_id" class="form-control" id="teacher_id" value="{{ $teacher->id }}" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary">إضافة</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
@foreach($teacher->groups as $group)
<div class="modal fade" id="addStudentModal{{ $group->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5 pb-5">
                <div class="text-center mb-4">
                    <h1 class="student-title">إضافة طالب إلى مجموعة</h1>
                </div>

                <!-- Form to add a new student to a group -->
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- HTML form -->
 
<form action="{{ route('students_in_groups.store') }}" method="POST" id="addStudentForm{{ $group->id }}" class="row">
    @csrf
    <div class="form-group">
        <label for="student_id">اسم الطالب</label>
        <select class="form-control select2" name="student_id" id="student_id" required>
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>
    </div>

    <input type="hidden" name="group_id" value="{{ $group->id }}">

    <button type="submit" class="btn btn-primary">إضافة</button>
</form>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script>
    $(document).ready(function() {
        $('#student_id').select2({
            placeholder: "اختر طالب",
            allowClear: true,
            ajax: {
                url: '/api/students', // تأكد من تحديث هذا المسار إلى المسار الصحيح لواجهة برمجة التطبيقات
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // النص الذي يبحث عنه المستخدم
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items // البيانات التي يتم إرجاعها من الخادم
                    };
                },
                cache: true
            }
        });
    });
</script>

@endforeach
@endsection

