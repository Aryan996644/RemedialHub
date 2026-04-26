<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    private function teacher()
    {
        return Teacher::where('user_id', auth()->id())->firstOrFail();
    }

    public function index()
    {
        $teacher = $this->teacher();
        $assignments = Assignment::where('teacher_id', $teacher->id)
            ->with(['course', 'student.user'])->latest()->get();
        $courses = Course::where('teacher_id', $teacher->id)->get();
        $students = Student::with('user')->get();
        return view('teacher.assignments.index', compact('assignments', 'courses', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:students,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after:today',
            'marks' => 'required|integer|min:1',
        ]);

        $teacher = $this->teacher();

        Assignment::create([
            'course_id' => $request->course_id,
            'teacher_id' => $teacher->id,
            'student_id' => $request->student_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'marks' => $request->marks,
            'status' => 'pending',
        ]);

        return redirect()->route('teacher.assignments')->with('success', 'Assignment created.');
    }

    public function destroy($id)
    {
        $teacher = $this->teacher();
        Assignment::where('teacher_id', $teacher->id)->findOrFail($id)->delete();
        return redirect()->route('teacher.assignments')->with('success', 'Assignment deleted.');
    }
}
