<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount',
        'payment_date',
        'notes',
        'payment_type',
        'user',
    ];

    /**
     * Get the student that owns the payment.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
