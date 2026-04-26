<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'remedial_class_id', 'student_id', 'status', 'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function remedialClass()
    {
        return $this->belongsTo(RemedialClass::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
