<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Assessment;
use App\Models\Teacher;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private function teacher()
    {
        return Teacher::where('user_id', auth()->id())->firstOrFail();
    }

    public function index(Request $request)
    {
        $teacher = $this->teacher();
        $assessments = Assessment::where('teacher_id', $teacher->id)->get();
        $selectedAssessment = null;
        $questions = collect();

        if ($request->filled('assessment_id')) {
            $selectedAssessment = Assessment::where('teacher_id', $teacher->id)
                ->findOrFail($request->assessment_id);
            $questions = Question::where('assessment_id', $selectedAssessment->id)
                ->orderBy('id')->get();
        }

        return view('teacher.questions.index', compact('assessments', 'selectedAssessment', 'questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'assessment_id' => 'required|exists:assessments,id',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:a,b,c,d',
            'marks' => 'required|integer|min:1',
        ]);

        Question::create($request->only(
            'assessment_id', 'question', 'option_a', 'option_b',
            'option_c', 'option_d', 'correct_option', 'marks'
        ));

        return redirect()->route('teacher.questions', ['assessment_id' => $request->assessment_id])
            ->with('success', 'Question added successfully.');
    }

    public function edit($id)
    {
        $teacher = $this->teacher();
        $question = Question::whereHas('assessment', fn($q) => $q->where('teacher_id', $teacher->id))->findOrFail($id);
        $assessments = Assessment::where('teacher_id', $teacher->id)->get();
        return view('teacher.questions.edit', compact('question', 'assessments'));
    }

    public function update(Request $request, $id)
    {
        $teacher = $this->teacher();
        $question = Question::whereHas('assessment', fn($q) => $q->where('teacher_id', $teacher->id))->findOrFail($id);

        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:a,b,c,d',
            'marks' => 'required|integer|min:1',
        ]);

        $question->update($request->only(
            'question', 'option_a', 'option_b', 'option_c',
            'option_d', 'correct_option', 'marks'
        ));

        return redirect()->route('teacher.questions', ['assessment_id' => $question->assessment_id])
            ->with('success', 'Question updated successfully.');
    }

    public function destroy($id)
    {
        $teacher = $this->teacher();
        $question = Question::whereHas('assessment', fn($q) => $q->where('teacher_id', $teacher->id))->findOrFail($id);
        $assessmentId = $question->assessment_id;
        $question->delete();
        return redirect()->route('teacher.questions', ['assessment_id' => $assessmentId])
            ->with('success', 'Question deleted successfully.');
    }
}
