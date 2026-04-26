<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'title', 'content', 'file_url', 'order_no', 'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
