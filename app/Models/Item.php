<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'image',
        'title',
    ];
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

}
