<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'roll_no', 'department', 'semester', 'section',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
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

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function progressReports()
    {
        return $this->hasMany(ProgressReport::class);
    }

    public function attendances()
    {
        return $this->hasMany(ClassAttendance::class);
    }

    public function latestResult()
    {
        return $this->hasOne(Result::class)->latest();
    }
}
