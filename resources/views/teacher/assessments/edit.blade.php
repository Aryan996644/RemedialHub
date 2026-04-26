@extends('layouts.teacher')
@section('title', 'Edit Assessment')
@section('page-title', 'Edit Assessment')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-title"><i class="fas fa-edit" style="color:#6366f1;"></i> Edit Assessment</div>
    <form method="POST" action="{{ route('teacher.assessments.update', $assessment->id) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Assessment Title</label>
            <input type="text" name="title" class="form-input" required value="{{ $assessment->title }}">
        </div>
        <div class="form-group">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-input" required value="{{ $assessment->category }}">
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label">Total Marks</label>
                <input type="number" name="total_marks" class="form-input" required min="1" value="{{ $assessment->total_marks }}">
            </div>
            <div class="form-group">
                <label class="form-label">Duration (minutes)</label>
                <input type="number" name="duration" class="form-input" required min="5" value="{{ $assessment->duration }}">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-input">
                <option value="active" {{ $assessment->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $assessment->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
            <a href="{{ route('teacher.assessments') }}" class="btn" style="background:#e2e8f0;color:#475569;">Cancel</a>
        </div>
    </form>
</div>
@endsection
