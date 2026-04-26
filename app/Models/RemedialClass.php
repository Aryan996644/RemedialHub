<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemedialClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'teacher_id', 'student_id', 'title', 'platform',
        'meeting_link', 'scheduled_at', 'duration', 'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function attendances()
    {
        return $this->hasMany(ClassAttendance::class);
    }
}
