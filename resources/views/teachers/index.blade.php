<!-- resources/views/teachers/index.blade.php -->
@extends('layouts.index')

@section('content')

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
                                    <span class="btn btn-primary mb-1">اضافة معلم جديد</span>
                                </a>
                                <p class="mb-0">يمكنك من هنا اضافة معلم جديد</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                </div>
            </div>
    
        <!-- Role cards -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5 pb-5">
                        <div class="text-center mb-4">
                            <h1 class="role-title">اضافة معلم جديد</h1>
                            <p>مرحبا بك </p>
                        </div>

                        <!-- Form to add a new course -->
                        <form action="{{ route('teachers.store') }}" method="POST" id="addCourseForm" class="row">
                            @csrf
                            <div class="form-group">
            <label for="name">اسم المعلم</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class="form-group">
            <label for="email">البريد الالكتروني</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">كلمة السر</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary">أضافة</button>
                        </form>
                        <!-- End of form -->
                    </div>
                </div>
            </div>
        </div>
    <table class="table">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>البريد الالكتروني</th>
                <th>كلمة المرور</th>

                <th>الاعدادت</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->password }}</td>

                <td>
                    <a href="{{ route('teachers.show', $teacher->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
