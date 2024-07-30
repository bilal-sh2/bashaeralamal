<?php

// في ملف Student.php في مجلد app\Models

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name','image', 'email','password','class_id', 'parent_phone1', 'parent_phone2', 'birthdate', 'address','gender','value_price',
        // يمكنك إضافة المزيد من الأعمدة حسب الحاجة
    ];
    public function school()
    {
        return $this->belongsTo(School::class);
    }
        

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
    

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subjects')->withPivot('grade');
    }
// في ملف Student.php

public function absences() {
    return $this->hasMany(Absence::class);
}

public function Notes() {
    return $this->hasMany(Note::class);
}

public function payments()
{
    return $this->hasMany(StudentPayment::class);
}
public function courses()
{
    return $this->hasMany(Course::class);
}




}
