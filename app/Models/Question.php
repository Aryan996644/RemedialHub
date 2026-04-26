<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id', 'question', 'option_a', 'option_b',
        'option_c', 'option_d', 'correct_option', 'marks',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
