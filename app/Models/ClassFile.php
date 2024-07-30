<?php

// في ملف app/Models/ClassFile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassFile extends Model
{
    protected $fillable = ['class_id', 'filePath', 'name'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // تعديل الدالة store() لتناسب Laravel
    public static function store($class_id, $filePath, $name)
    {
        return self::create([
            'class_id' => $class_id,
            'filePath' => $filePath,
            'name' => $name,
        ]);
    }
}
