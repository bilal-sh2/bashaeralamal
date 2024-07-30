<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = ['name','email','password', 'school_id'];
    


public function students()
{
    return $this->hasMany(Student::class);
}


   public function school()
    {
        return $this->belongsTo(School::class);
    }


}
