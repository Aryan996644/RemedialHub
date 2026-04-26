@extends('layouts.teacher')
@section('title', 'Edit Question')
@section('page-title', 'Edit Question')

@section('content')
<div class="card" style="max-width:680px;">
    <div class="card-title"><i class="fas fa-edit" style="color:#6366f1;"></i> Edit MCQ Question</div>
    <form method="POST" action="{{ route('teacher.questions.update', $question->id) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Assessment</label>
            <select name="assessment_id" class="form-input">
                @foreach($assessments as $a)
                    <option value="{{ $a->id }}" {{ $question->assessment_id == $a->id ? 'selected' : '' }}>{{ $a->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Question</label>
            <textarea name="question" class="form-input" required rows="3">{{ $question->question }}</textarea>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="form-group"><label class="form-label">Option A</label><input type="text" name="option_a" class="form-input" required value="{{ $question->option_a }}"></div>
            <div class="form-group"><label class="form-label">Option B</label><input type="text" name="option_b" class="form-input" required value="{{ $question->option_b }}"></div>
            <div class="form-group"><label class="form-label">Option C</label><input type="text" name="option_c" class="form-input" required value="{{ $question->option_c }}"></div>
            <div class="form-group"><label class="form-label">Option D</label><input type="text" name="option_d" class="form-input" required value="{{ $question->option_d }}"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="form-group">
                <label class="form-label">Correct Answer</label>
                <select name="correct_option" class="form-input">
                    @foreach(['a','b','c','d'] as $opt)
                        <option value="{{ $opt }}" {{ $question->correct_option === $opt ? 'selected' : '' }}>{{ strtoupper($opt) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Marks</label>
                <input type="number" name="marks" class="form-input" required min="1" value="{{ $question->marks }}">
            </div>
        </div>
        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Question</button>
            <a href="{{ route('teacher.questions', ['assessment_id' => $question->assessment_id]) }}" class="btn" style="background:#e2e8f0;color:#475569;">Cancel</a>
        </div>
    </form>
</div>
@endsection
