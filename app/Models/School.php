<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['name', 'type','aco'];

    public function teacher() {
        return $this->hasMany(Teacher::class);
    }

 

    public function schoolclass()
    {
        return $this->hasMany(SchoolClass::class);
    }


    public function subject()
    {
        return $this->hasMany(Subject::class);
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }

    // Define the hasManyThrough relationship
    public function students()
    {
        return $this->hasManyThrough(Student::class, SchoolClass::class, 'school_id', 'class_id');
    }
}
