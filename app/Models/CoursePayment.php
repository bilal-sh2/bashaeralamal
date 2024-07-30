<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes',
        'user',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
