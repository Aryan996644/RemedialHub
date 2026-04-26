<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'title', 'description', 'category', 'level',
        'duration', 'thumbnail', 'status',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function videos()
    {
        return $this->hasMany(CourseVideo::class)->orderBy('order_no');
    }

    public function articles()
    {
        return $this->hasMany(CourseArticle::class)->orderBy('order_no');
    }

    public function recommendations()
    {
        return $this->hasMany(CourseRecommendation::class);
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function remedialClasses()
    {
        return $this->hasMany(RemedialClass::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function progressReports()
    {
        return $this->hasMany(ProgressReport::class);
    }
}
