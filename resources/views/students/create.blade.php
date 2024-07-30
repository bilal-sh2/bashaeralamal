@extends('layouts.index')

@section('content')

    <a class="btn btn-primary" href="{{ route('school_class.show',$id )}}">رجوع</a>

    <div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-primary" role="alert">
                {{$message}}
            </div>
        @endif
    </div>

    @if($errors->has('email'))
    <div class="alert alert-danger">
        {{ $errors->first('email') }}
    </div>
@endif


            <section id="basic-vertical-layouts">
    <div class="row">
    <div class="col-12">
    <div class="card">
                <div class="card-header">
                    <h4 class="card-title">اضافة طالب جديد</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('student.store')}}" method="POST" enctype="multipart/form-data" class="form form-vertical">
                        @csrf
                        <input type="hidden" class="form-control" id="num" name="class_id" required value={{$id}}>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="image" class="form-label">اختر صورة الشخصية للطالب:</label>
                                    <input type="file" class="form-control" id="image" name="mimage" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="name" class="form-label">اسم الطالب</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="gender" class="form-label">الجنس</label>
                                    <select name="gender" class="form-select" required dir="ltr">
                                        <option value=" " selected> </option>
                                        <option value="ذكر">ذكر</option>
                                        <option value="أنثى">أنثى</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="password" class="form-label">كلمة السر</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="birthdate" class="form-label">تاريخ الميلاد</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="address" class="form-label">عنوان سكن الطالب</label>
                                    <input type="text" class="form-control" id="address" name="address" required maxlength="20">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="parent_phone1" class="form-label">رقم التواصل الأول</label>
                                    <input type="text" class="form-control" id="parent_phone1" name="parent_phone1">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="parent_phone2" class="form-label">رقم التواصل الثاني</label>
                                    <input type="text" class="form-control" id="parent_phone2" name="parent_phone2" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="value_price" class="form-label">قسط الطالب</label>
                                    <input type="number" class="form-control" id="value_price" name="value_price" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">أضافة</button>
                                <button type="reset" class="btn btn-outline-secondary">إعادة تعيين</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

   
@endsection
