@extends('layouts.teacher')
@section('title', 'Create Assessment')
@section('page-title', 'Create Assessment')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-title"><i class="fas fa-clipboard-check" style="color:#6366f1;"></i> New Assessment</div>
    <form method="POST" action="{{ route('teacher.assessments.store') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Assessment Title</label>
            <input type="text" name="title" class="form-input" required placeholder="e.g., Programming Skill Assessment" value="{{ old('title') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-input" required placeholder="e.g., Programming, Mathematics" value="{{ old('category') }}">
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label">Total Marks</label>
                <input type="number" name="total_marks" class="form-input" required min="1" value="{{ old('total_marks', 20) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Duration (minutes)</label>
                <input type="number" name="duration" class="form-input" required min="5" value="{{ old('duration', 30) }}">
            </div>
        </div>
        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Assessment</button>
            <a href="{{ route('teacher.assessments') }}" class="btn" style="background:#e2e8f0;color:#475569;">Cancel</a>
        </div>
    </form>
</div>
@endsection
