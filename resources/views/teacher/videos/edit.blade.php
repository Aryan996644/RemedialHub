@extends('layouts.teacher')
@section('title', 'Edit Video')
@section('page-title', 'Edit Video Lesson')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-title"><i class="fas fa-edit" style="color:#6366f1;"></i> Edit Video</div>
    <form method="POST" action="{{ route('teacher.videos.update', $video->id) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Select Course</label>
            <select name="course_id" class="form-input" required>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $video->course_id == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Video Title</label>
            <input type="text" name="title" class="form-input" required value="{{ $video->title }}">
        </div>
        <div class="form-group">
            <label class="form-label">Video URL</label>
            <input type="url" name="video_url" class="form-input" required value="{{ $video->video_url }}">
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label">Duration</label>
                <input type="text" name="duration" class="form-input" value="{{ $video->duration }}">
            </div>
            <div class="form-group">
                <label class="form-label">Order Number</label>
                <input type="number" name="order_no" class="form-input" required min="1" value="{{ $video->order_no }}">
            </div>
        </div>
        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Video</button>
            <a href="{{ route('teacher.videos') }}" class="btn" style="background:#e2e8f0;color:#475569;">Cancel</a>
        </div>
    </form>
</div>
@endsection
