@extends('layouts.teacher')
@section('title', 'Create Course')
@section('page-title', 'Create New Course')

@section('content')
<div class="card" style="max-width:680px;">
    <div class="card-title"><i class="fas fa-book-plus" style="color:#6366f1;"></i> Create Course</div>
    <form method="POST" action="{{ route('teacher.courses.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Course Title</label>
            <input type="text" name="title" class="form-input" required placeholder="e.g., Basic Programming" value="{{ old('title') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-input" rows="4" placeholder="Describe what students will learn...">{{ old('description') }}</textarea>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-input" required placeholder="e.g., Programming, Math" value="{{ old('category') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Level</label>
                <select name="level" class="form-input">
                    <option value="beginner" {{ old('level') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="intermediate" {{ old('level') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="advanced" {{ old('level') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Duration (e.g., 4 weeks)</label>
            <input type="text" name="duration" class="form-input" placeholder="e.g., 4 weeks" value="{{ old('duration') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Thumbnail Image (optional)</label>
            <input type="file" name="thumbnail" class="form-input" accept="image/*">
        </div>
        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Course</button>
            <a href="{{ route('teacher.courses') }}" class="btn" style="background:#e2e8f0;color:#475569;">Cancel</a>
        </div>
    </form>
</div>
@endsection
