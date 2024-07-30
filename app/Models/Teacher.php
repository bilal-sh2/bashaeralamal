<?php
// app/Models/Teacher.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name', 'email', 'password',
    ];

    // لا تقم بتشفير كلمة المرور في الموديل


    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
