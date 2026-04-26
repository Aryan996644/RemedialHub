<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id', 'student_id', 'score', 'total_marks',
        'percentage', 'skill_level', 'status',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function recommendations()
    {
        return $this->hasMany(CourseRecommendation::class);
    }
}
