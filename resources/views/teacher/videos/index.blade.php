@extends('layouts.teacher')
@section('title', 'Video Lessons')
@section('page-title', 'Video Lessons')

@section('content')
<div class="grid-2">
    <!-- Add Video Form -->
    <div class="card">
        <div class="card-title"><i class="fas fa-plus-circle" style="color:#6366f1;"></i> Add Video Lesson</div>
        <form method="POST" action="{{ route('teacher.videos.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Select Course</label>
                <select name="course_id" class="form-input" required>
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Video Title</label>
                <input type="text" name="title" class="form-input" required placeholder="e.g., What is Programming?">
            </div>
            <div class="form-group">
                <label class="form-label">Video URL (YouTube/Vimeo)</label>
                <input type="url" name="video_url" class="form-input" required placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-input" placeholder="e.g., 15 min">
                </div>
                <div class="form-group">
                    <label class="form-label">Order Number</label>
                    <input type="number" name="order_no" class="form-input" required min="1" value="1">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Add Video</button>
        </form>
    </div>

    <!-- Videos List -->
    <div class="card">
        <div class="card-title"><i class="fas fa-list" style="color:#6366f1;"></i> All Video Lessons ({{ $videos->count() }})</div>
        @forelse($videos as $video)
        <div style="padding:12px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:8px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div style="flex:1;">
                    <div style="font-weight:600;font-size:14px;">{{ $video->order_no }}. {{ $video->title }}</div>
                    <div style="font-size:12px;color:#6366f1;margin-top:2px;">{{ $video->course->title }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;"><i class="fas fa-clock"></i> {{ $video->duration }}</div>
                </div>
                <div style="display:flex;gap:4px;">
                    <a href="{{ route('teacher.videos.edit', $video->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('teacher.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p style="color:#94a3b8;font-size:14px;text-align:center;padding:32px;">No videos added yet</p>
        @endforelse
    </div>
</div>
@endsection
