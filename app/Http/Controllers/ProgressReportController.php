<?php

namespace App\Http\Controllers;

use App\Models\ProgressReport;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ProgressReportController extends Controller
{
    public function index()
    {
        $teacher = Teacher::where('user_id', auth()->id())->firstOrFail();
        $reports = ProgressReport::where('teacher_id', $teacher->id)
            ->with(['student.user', 'course'])->latest()->get();
        $courses = Course::where('teacher_id', $teacher->id)->get();
        $students = Student::with('user')->get();
        return view('teacher.progress.index', compact('reports', 'courses', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'initial_score' => 'required|numeric|min:0|max:100',
            'current_score' => 'required|numeric|min:0|max:100',
            'remarks' => 'nullable|string',
        ]);

        $teacher = Teacher::where('user_id', auth()->id())->firstOrFail();
        $progress = $request->current_score - $request->initial_score;
        $progressPercentage = $request->initial_score > 0
            ? round((($request->current_score - $request->initial_score) / $request->initial_score) * 100, 2)
            : ($request->current_score > 0 ? 100 : 0);

        $status = 'Stagnant';
        if ($progress > 0) $status = 'Improved';
        if ($progress < 0) $status = 'Declined';

        ProgressReport::create([
            'student_id' => $request->student_id,
            'teacher_id' => $teacher->id,
            'course_id' => $request->course_id,
            'initial_score' => $request->initial_score,
            'current_score' => $request->current_score,
            'progress_percentage' => $progressPercentage,
            'status' => $status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('teacher.progress')->with('success', 'Progress report saved.');
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::where('user_id', auth()->id())->firstOrFail();
        $report = ProgressReport::where('teacher_id', $teacher->id)->findOrFail($id);

        $request->validate([
            'current_score' => 'required|numeric|min:0|max:100',
            'remarks' => 'nullable|string',
        ]);

        $progress = $request->current_score - $report->initial_score;
        $progressPercentage = $report->initial_score > 0
            ? round((($request->current_score - $report->initial_score) / $report->initial_score) * 100, 2)
            : ($request->current_score > 0 ? 100 : 0);

        $status = 'Stagnant';
        if ($progress > 0) $status = 'Improved';
        if ($progress < 0) $status = 'Declined';

        $report->update([
            'current_score' => $request->current_score,
            'progress_percentage' => $progressPercentage,
            'status' => $status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('teacher.progress')->with('success', 'Progress updated.');
    }
}
