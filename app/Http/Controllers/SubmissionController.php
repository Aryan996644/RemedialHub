<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Assignment;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        $teacher = Teacher::where('user_id', auth()->id())->firstOrFail();
        $submissions = Submission::with(['assignment.course', 'student.user'])
            ->whereHas('assignment', fn($q) => $q->where('teacher_id', $teacher->id))
            ->latest()->get();
        return view('teacher.submissions.index', compact('submissions'));
    }

    public function grade(Request $request, $id)
    {
        $request->validate([
            'obtained_marks' => 'required|integer|min:0',
            'feedback' => 'nullable|string',
        ]);

        $submission = Submission::findOrFail($id);
        $submission->update([
            'obtained_marks' => $request->obtained_marks,
            'feedback' => $request->feedback,
            'status' => 'graded',
        ]);

        $submission->assignment->update(['status' => 'graded']);

        return back()->with('success', 'Submission graded successfully.');
    }
}
