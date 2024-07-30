<?php

// ملف النموذج: app/Models/StudentSubject.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    protected $table = 'student_subjects';

    protected $fillable = [
        'student_id',
        'subject_id',
        'grade',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
