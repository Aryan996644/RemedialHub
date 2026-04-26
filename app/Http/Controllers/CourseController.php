<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private function teacher()
    {
        return Teacher::where('user_id', auth()->id())->firstOrFail();
    }

    public function index()
    {
        $teacher = $this->teacher();
        $courses = Course::where('teacher_id', $teacher->id)
            ->withCount(['videos', 'articles', 'enrollments'])->latest()->get();
        return view('teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('teacher.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $teacher = $this->teacher();
        $data = $request->only('title', 'description', 'category', 'level', 'duration');
        $data['teacher_id'] = $teacher->id;
        $data['status'] = 'pending';

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Course::create($data);
        return redirect()->route('teacher.courses')->with('success', 'Course created successfully.');
    }

    public function show($id)
    {
        $teacher = $this->teacher();
        $course = Course::where('teacher_id', $teacher->id)
            ->withCount(['videos', 'articles', 'enrollments'])
            ->with(['videos', 'articles', 'assignments.student.user', 'remedialClasses.student.user', 'enrollments.student.user'])
            ->findOrFail($id);
        return view('teacher.courses.show', compact('course'));
    }

    public function edit($id)
    {
        $teacher = $this->teacher();
        $course = Course::where('teacher_id', $teacher->id)->findOrFail($id);
        return view('teacher.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $teacher = $this->teacher();
        $course = Course::where('teacher_id', $teacher->id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('title', 'description', 'category', 'level', 'duration');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($data);
        return redirect()->route('teacher.courses')->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $teacher = $this->teacher();
        Course::where('teacher_id', $teacher->id)->findOrFail($id)->delete();
        return redirect()->route('teacher.courses')->with('success', 'Course deleted successfully.');
    }
}
