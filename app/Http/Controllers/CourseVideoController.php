<?php

namespace App\Http\Controllers;

use App\Models\CourseVideo;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseVideoController extends Controller
{
    private function teacher()
    {
        return Teacher::where('user_id', auth()->id())->firstOrFail();
    }

    public function index()
    {
        $teacher = $this->teacher();
        $videos = CourseVideo::whereHas('course', fn($q) => $q->where('teacher_id', $teacher->id))
            ->with('course')->orderBy('order_no')->get();
        $courses = Course::where('teacher_id', $teacher->id)->get();
        return view('teacher.videos.index', compact('videos', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'duration' => 'nullable|string',
            'order_no' => 'required|integer|min:1',
        ]);

        CourseVideo::create($request->only('course_id', 'title', 'video_url', 'duration', 'order_no'));
        return redirect()->route('teacher.videos')->with('success', 'Video lesson added successfully.');
    }

    public function edit($id)
    {
        $teacher = $this->teacher();
        $video = CourseVideo::whereHas('course', fn($q) => $q->where('teacher_id', $teacher->id))->findOrFail($id);
        $courses = Course::where('teacher_id', $teacher->id)->get();
        return view('teacher.videos.edit', compact('video', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $teacher = $this->teacher();
        $video = CourseVideo::whereHas('course', fn($q) => $q->where('teacher_id', $teacher->id))->findOrFail($id);

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'duration' => 'nullable|string',
            'order_no' => 'required|integer|min:1',
        ]);

        $video->update($request->only('course_id', 'title', 'video_url', 'duration', 'order_no'));
        return redirect()->route('teacher.videos')->with('success', 'Video updated successfully.');
    }

    public function destroy($id)
    {
        $teacher = $this->teacher();
        CourseVideo::whereHas('course', fn($q) => $q->where('teacher_id', $teacher->id))->findOrFail($id)->delete();
        return redirect()->route('teacher.videos')->with('success', 'Video deleted successfully.');
    }
}
