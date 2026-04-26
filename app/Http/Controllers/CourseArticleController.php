<?php

namespace App\Http\Controllers;

use App\Models\CourseArticle;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseArticleController extends Controller
{
    private function teacher()
    {
        return Teacher::where('user_id', auth()->id())->firstOrFail();
    }

    public function index()
    {
        $teacher = $this->teacher();
        $articles = CourseArticle::whereHas('course', fn($q) => $q->where('teacher_id', $teacher->id))
            ->with('course')->orderBy('order_no')->get();
        $courses = Course::where('teacher_id', $teacher->id)->get();
        return view('teacher.articles.index', compact('articles', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'order_no' => 'required|integer|min:1',
        ]);

        $data = $request->only('course_id', 'title', 'content', 'order_no');

        if ($request->hasFile('file')) {
            $data['file_url'] = $request->file('file')->store('articles', 'public');
        }

        CourseArticle::create($data);
        return redirect()->route('teacher.articles')->with('success', 'Article added successfully.');
    }

    public function edit($id)
    {
        $teacher = $this->teacher();
        $article = CourseArticle::whereHas('course', fn($q) => $q->where('teacher_id', $teacher->id))->findOrFail($id);
        $courses = Course::where('teacher_id', $teacher->id)->get();
        return view('teacher.articles.edit', compact('article', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $teacher = $this->teacher();
        $article = CourseArticle::whereHas('course', fn($q) => $q->where('teacher_id', $teacher->id))->findOrFail($id);

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'order_no' => 'required|integer|min:1',
        ]);

        $data = $request->only('course_id', 'title', 'content', 'order_no');

        if ($request->hasFile('file')) {
            $data['file_url'] = $request->file('file')->store('articles', 'public');
        }

        $article->update($data);
        return redirect()->route('teacher.articles')->with('success', 'Article updated successfully.');
    }

    public function destroy($id)
    {
        $teacher = $this->teacher();
        CourseArticle::whereHas('course', fn($q) => $q->where('teacher_id', $teacher->id))->findOrFail($id)->delete();
        return redirect()->route('teacher.articles')->with('success', 'Article deleted successfully.');
    }
}
