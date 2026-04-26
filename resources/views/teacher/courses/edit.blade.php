@extends('layouts.teacher')
@section('title', 'Edit Course')
@section('page-title', 'Edit Course')

@section('content')
<div class="card" style="max-width:680px;">
    <div class="card-title"><i class="fas fa-edit" style="color:#6366f1;"></i> Edit Course</div>
    <form method="POST" action="{{ route('teacher.courses.update', $course->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Course Title</label>
            <input type="text" name="title" class="form-input" required value="{{ $course->title }}">
        </div>
        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-input" rows="4">{{ $course->description }}</textarea>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-input" required value="{{ $course->category }}">
            </div>
            <div class="form-group">
                <label class="form-label">Level</label>
                <select name="level" class="form-input">
                    @foreach(['beginner','intermediate','advanced'] as $l)
                        <option value="{{ $l }}" {{ $course->level === $l ? 'selected' : '' }}>{{ ucfirst($l) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Duration</label>
            <input type="text" name="duration" class="form-input" value="{{ $course->duration }}">
        </div>
        <div class="form-group">
            <label class="form-label">New Thumbnail (optional)</label>
            <input type="file" name="thumbnail" class="form-input" accept="image/*">
        </div>
        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Course</button>
            <a href="{{ route('teacher.courses') }}" class="btn" style="background:#e2e8f0;color:#475569;">Cancel</a>
        </div>
    </form>
</div>
@endsection
