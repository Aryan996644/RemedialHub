<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function teacherResults()
    {
        $teacher = Teacher::where('user_id', auth()->id())->firstOrFail();
        $results = Result::with(['student.user', 'assessment'])
            ->whereHas('assessment', fn($q) => $q->where('teacher_id', $teacher->id))
            ->latest()->get();
        return view('teacher.results.index', compact('results'));
    }

    public function slowLearners()
    {
        $teacher = Teacher::where('user_id', auth()->id())->firstOrFail();
        $slowLearners = Result::with(['student.user', 'assessment'])
            ->whereHas('assessment', fn($q) => $q->where('teacher_id', $teacher->id))
            ->where('status', 'slow_learner')->latest()->get();

        $courses = \App\Models\Course::where('teacher_id', $teacher->id)->get();
        return view('teacher.slow-learners.index', compact('slowLearners', 'courses'));
    }
}
