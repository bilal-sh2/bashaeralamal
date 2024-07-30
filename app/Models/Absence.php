<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = ['student_id', 'date','reason'];

    public function students()
    {
        return $this->belongsTo(Student::class);
    }
}
