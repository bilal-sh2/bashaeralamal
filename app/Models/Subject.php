<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $fillable = [
        'name','school_id'
        // يمكنك إضافة المزيد من الأعمدة حسب الحاجة
    ];
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subjects')->withPivot('grade');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }


}

    