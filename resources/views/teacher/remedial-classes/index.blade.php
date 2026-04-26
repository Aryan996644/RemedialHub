@extends('layouts.teacher')
@section('title', 'Remedial Classes')
@section('page-title', 'Remedial Video Classes')

@section('content')
<div class="grid-2">
    <!-- Schedule Form -->
    <div class="card">
        <div class="card-title"><i class="fas fa-plus-circle" style="color:#3b82f6;"></i> Schedule Remedial Class</div>
        <form method="POST" action="{{ route('teacher.remedial-classes.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Class Title</label>
                <input type="text" name="title" class="form-input" required placeholder="e.g., Programming Basics - Remedial">
            </div>
            <div class="form-group">
                <label class="form-label">Select Course</label>
                <select name="course_id" class="form-input" required>
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}">{{ $c->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Select Student</label>
                <select name="student_id" class="form-input" required>
                    <option value="">-- Select Student --</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}">{{ $s->user->name }} ({{ $s->roll_no }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Platform</label>
                <select name="platform" class="form-input" required>
                    <option value="Google Meet">Google Meet</option>
                    <option value="Zoom">Zoom</option>
                    <option value="Custom Link">Custom Link</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Meeting Link</label>
                <input type="url" name="meeting_link" class="form-input" required placeholder="https://meet.google.com/...">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div class="form-group">
                    <label class="form-label">Scheduled Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Duration (minutes)</label>
                    <input type="number" name="duration" class="form-input" required min="15" value="60">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-calendar-plus"></i> Schedule Class</button>
        </form>
    </div>

    <!-- Classes List -->
    <div class="card">
        <div class="card-title"><i class="fas fa-list" style="color:#3b82f6;"></i> Scheduled Classes ({{ $classes->count() }})</div>
        <div style="max-height:620px;overflow-y:auto;">
            @forelse($classes as $class)
            <div style="padding:14px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:10px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px;">
                    <div>
                        <div style="font-weight:600;font-size:14px;">{{ $class->title }}</div>
                        <div style="font-size:12px;color:#6366f1;">{{ $class->course->title }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;">
                            <i class="fas fa-user"></i> {{ $class->student->user->name }} &nbsp;
                            <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($class->scheduled_at)->format('M d, Y h:i A') }} &nbsp;
                            <i class="fas fa-hourglass-half"></i> {{ $class->duration }} min
                        </div>
                    </div>
                    @if($class->status === 'upcoming')<span class="badge badge-info">Upcoming</span>
                    @elseif($class->status === 'live')<span class="badge badge-danger">🔴 Live</span>
                    @elseif($class->status === 'completed')<span class="badge badge-success">Done</span>
                    @else<span class="badge badge-warning">Cancelled</span>@endif
                </div>
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    <a href="{{ $class->meeting_link }}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-video"></i> {{ $class->platform }}</a>
                    @if($class->status === 'upcoming')
                    <form action="{{ route('teacher.remedial-classes.status', $class->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Mark Done</button>
                    </form>
                    @endif
                    <form action="{{ route('teacher.remedial-classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            @empty
            <div style="text-align:center;color:#94a3b8;padding:48px;">
                <i class="fas fa-video" style="font-size:40px;color:#e2e8f0;display:block;margin-bottom:8px;"></i>
                No classes scheduled yet
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
