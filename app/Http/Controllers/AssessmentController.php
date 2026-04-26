<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    private function teacher()
    {
        return Teacher::where('user_id', auth()->id())->firstOrFail();
    }

    public function index()
    {
        $teacher = $this->teacher();
        $assessments = Assessment::where('teacher_id', $teacher->id)
            ->withCount(['questions', 'results'])->latest()->get()
            ->map(function ($a) {
                $a->avg_score = $a->results->count() > 0 ? round($a->results->avg('percentage'), 1) : 0;
                return $a;
            });
        return view('teacher.assessments.index', compact('assessments'));
    }

    public function create()
    {
        return view('teacher.assessments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'total_marks' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
        ]);

        $teacher = $this->teacher();
        Assessment::create([
            'teacher_id' => $teacher->id,
            'title' => $request->title,
            'category' => $request->category,
            'total_marks' => $request->total_marks,
            'duration' => $request->duration,
            'status' => 'active',
        ]);

        return redirect()->route('teacher.assessments')->with('success', 'Assessment created successfully.');
    }

    public function edit($id)
    {
        $teacher = $this->teacher();
        $assessment = Assessment::where('teacher_id', $teacher->id)->findOrFail($id);
        return view('teacher.assessments.edit', compact('assessment'));
    }

    public function update(Request $request, $id)
    {
        $teacher = $this->teacher();
        $assessment = Assessment::where('teacher_id', $teacher->id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'total_marks' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $assessment->update($request->only('title', 'category', 'total_marks', 'duration', 'status'));
        return redirect()->route('teacher.assessments')->with('success', 'Assessment updated successfully.');
    }

    public function destroy($id)
    {
        $teacher = $this->teacher();
        Assessment::where('teacher_id', $teacher->id)->findOrFail($id)->delete();
        return redirect()->route('teacher.assessments')->with('success', 'Assessment deleted successfully.');
    }
}
