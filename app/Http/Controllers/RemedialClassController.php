<?php

namespace App\Http\Controllers;

use App\Models\RemedialClass;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class RemedialClassController extends Controller
{
    private function teacher()
    {
        return Teacher::where('user_id', auth()->id())->firstOrFail();
    }

    public function index()
    {
        $teacher = $this->teacher();
        $classes = RemedialClass::where('teacher_id', $teacher->id)
            ->with(['student.user', 'course'])->orderBy('scheduled_at', 'desc')->get();
        $courses = Course::where('teacher_id', $teacher->id)->get();
        $students = Student::with('user')->get();
        return view('teacher.remedial-classes.index', compact('classes', 'courses', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:students,id',
            'scheduled_at' => 'required|date|after:now',
            'duration' => 'required|integer|min:15',
            'platform' => 'required|in:Google Meet,Zoom,Custom Link',
            'meeting_link' => 'required|url',
        ]);

        $teacher = $this->teacher();

        RemedialClass::create([
            'course_id' => $request->course_id,
            'teacher_id' => $teacher->id,
            'student_id' => $request->student_id,
            'title' => $request->title,
            'platform' => $request->platform,
            'meeting_link' => $request->meeting_link,
            'scheduled_at' => $request->scheduled_at,
            'duration' => $request->duration,
            'status' => 'upcoming',
        ]);

        return redirect()->route('teacher.remedial-classes')->with('success', 'Remedial class scheduled.');
    }

    public function updateStatus(Request $request, $id)
    {
        $teacher = $this->teacher();
        $class = RemedialClass::where('teacher_id', $teacher->id)->findOrFail($id);
        $class->update(['status' => $request->status]);
        return back()->with('success', 'Class status updated.');
    }

    public function destroy($id)
    {
        $teacher = $this->teacher();
        RemedialClass::where('teacher_id', $teacher->id)->findOrFail($id)->delete();
        return redirect()->route('teacher.remedial-classes')->with('success', 'Class deleted.');
    }
}
