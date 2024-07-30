<?php

// app/Models/StudentsInGroup.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsInGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'student_name',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
