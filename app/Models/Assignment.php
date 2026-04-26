<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'teacher_id', 'student_id', 'title',
        'description', 'due_date', 'marks', 'status',
    ];

    protected $casts = [
        'due_date' => 'date',
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

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function latestSubmission()
    {
        return $this->hasOne(Submission::class)->latest();
    }
}
