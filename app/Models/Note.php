<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['student_id', 'type', 'notes'];

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}
