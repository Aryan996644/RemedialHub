@extends('layouts.teacher')
@section('title', 'Question Builder')
@section('page-title', 'MCQ Question Builder')

@section('content')
<!-- Assessment Filter -->
<div class="card" style="margin-bottom:20px;">
    <form method="GET" action="{{ route('teacher.questions') }}" style="display:flex;gap:16px;align-items:flex-end;">
        <div style="flex:1;">
            <label class="form-label">Select Assessment</label>
            <select name="assessment_id" class="form-input" onchange="this.form.submit()">
                <option value="">-- Choose Assessment --</option>
                @foreach($assessments as $a)
                    <option value="{{ $a->id }}" {{ request('assessment_id') == $a->id ? 'selected' : '' }}>
                        {{ $a->title }} ({{ $a->category }})
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

@if($selectedAssessment)
<div class="grid-2">
    <!-- Add Question Form -->
    <div class="card">
        <div class="card-title"><i class="fas fa-plus-circle" style="color:#6366f1;"></i> Add MCQ Question</div>
        <div style="background:#eff6ff;border-radius:10px;padding:12px;margin-bottom:16px;font-size:13px;color:#1e40af;">
            <i class="fas fa-info-circle"></i>
            <strong>{{ $selectedAssessment->title }}</strong> — Total Marks: {{ $selectedAssessment->total_marks }} | Questions: {{ $questions->count() }}
        </div>
        <form method="POST" action="{{ route('teacher.questions.store') }}">
            @csrf
            <input type="hidden" name="assessment_id" value="{{ $selectedAssessment->id }}">
            <div class="form-group">
                <label class="form-label">Question</label>
                <textarea name="question" class="form-input" required rows="3" placeholder="Write your question here..."></textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div class="form-group">
                    <label class="form-label">Option A</label>
                    <input type="text" name="option_a" class="form-input" required placeholder="Option A">
                </div>
                <div class="form-group">
                    <label class="form-label">Option B</label>
                    <input type="text" name="option_b" class="form-input" required placeholder="Option B">
                </div>
                <div class="form-group">
                    <label class="form-label">Option C</label>
                    <input type="text" name="option_c" class="form-input" required placeholder="Option C">
                </div>
                <div class="form-group">
                    <label class="form-label">Option D</label>
                    <input type="text" name="option_d" class="form-input" required placeholder="Option D">
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div class="form-group">
                    <label class="form-label">Correct Answer</label>
                    <select name="correct_option" class="form-input" required>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Marks</label>
                    <input type="number" name="marks" class="form-input" required min="1" value="1">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Question</button>
        </form>
    </div>

    <!-- Questions List -->
    <div class="card">
        <div class="card-title"><i class="fas fa-list-ol" style="color:#6366f1;"></i> Questions ({{ $questions->count() }})</div>
        <div style="max-height:600px;overflow-y:auto;">
            @forelse($questions as $i => $q)
            <div style="padding:14px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:10px;position:relative;">
                <div style="font-weight:600;font-size:14px;margin-bottom:10px;color:#1e293b;">
                    Q{{ $i+1 }}. {{ $q->question }}
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;">
                    @foreach(['a'=>$q->option_a,'b'=>$q->option_b,'c'=>$q->option_c,'d'=>$q->option_d] as $letter=>$opt)
                    <div style="padding:6px 10px;border-radius:6px;font-size:13px;background:{{ $q->correct_option === $letter ? '#dcfce7' : '#f8fafc' }};border:1px solid {{ $q->correct_option === $letter ? '#86efac' : '#e2e8f0' }};color:{{ $q->correct_option === $letter ? '#166534' : '#475569' }};">
                        <strong>{{ strtoupper($letter) }}.</strong> {{ $opt }}
                        @if($q->correct_option === $letter) <i class="fas fa-check" style="float:right;"></i>@endif
                    </div>
                    @endforeach
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px;">
                    <span style="font-size:12px;color:#6366f1;"><i class="fas fa-star"></i> {{ $q->marks }} mark(s)</span>
                    <div style="display:flex;gap:4px;">
                        <a href="{{ route('teacher.questions.edit', $q->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('teacher.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Delete question?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center;color:#94a3b8;padding:32px;">
                <i class="fas fa-question-circle" style="font-size:40px;display:block;margin-bottom:8px;color:#e2e8f0;"></i>
                No questions added yet
            </div>
            @endforelse
        </div>
    </div>
</div>
@else
<div style="text-align:center;padding:64px;background:#fff;border-radius:16px;border:1px solid #e2e8f0;">
    <i class="fas fa-clipboard-list" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px;"></i>
    <p style="color:#64748b;font-size:16px;">Select an assessment above to add questions</p>
</div>
@endif
@endsection
