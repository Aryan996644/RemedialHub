@extends('layouts.student')
@section('title', $course->title)
@section('page-title', $course->title)

@section('content')
<!-- Course Header -->
<div style="background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:20px;padding:28px 32px;margin-bottom:24px;color:#fff;">
    <h2 style="font-size:22px;font-weight:700;margin-bottom:8px;">{{ $course->title }}</h2>
    <p style="opacity:0.85;font-size:14px;max-width:600px;line-height:1.6;">{{ $course->description }}</p>
    <div style="display:flex;gap:16px;flex-wrap:wrap;margin-top:16px;">
        <span style="background:rgba(255,255,255,0.2);padding:4px 12px;border-radius:20px;font-size:12px;"><i class="fas fa-tag"></i> {{ $course->category }}</span>
        <span style="background:rgba(255,255,255,0.2);padding:4px 12px;border-radius:20px;font-size:12px;"><i class="fas fa-layer-group"></i> {{ ucfirst($course->level) }}</span>
        <span style="background:rgba(255,255,255,0.2);padding:4px 12px;border-radius:20px;font-size:12px;"><i class="fas fa-clock"></i> {{ $course->duration }}</span>
        <span style="background:rgba(255,255,255,0.2);padding:4px 12px;border-radius:20px;font-size:12px;"><i class="fas fa-chalkboard-teacher"></i> {{ $course->teacher->user->name }}</span>
        <span style="background:rgba(255,255,255,0.2);padding:4px 12px;border-radius:20px;font-size:12px;"><i class="fas fa-play-circle"></i> {{ $course->videos_count }} Videos</span>
        <span style="background:rgba(255,255,255,0.2);padding:4px 12px;border-radius:20px;font-size:12px;"><i class="fas fa-file-alt"></i> {{ $course->articles_count }} Articles</span>
    </div>
</div>

@if(!$enrolled)
<div style="background:#fffbeb;border:1px solid #fcd34d;border-radius:12px;padding:16px 24px;margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;">
    <div style="font-size:14px;color:#92400e;"><i class="fas fa-info-circle"></i> Enroll to access all video lessons and articles.</div>
    <form action="{{ route('student.enroll') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <button type="submit" class="btn btn-success"><i class="fas fa-graduation-cap"></i> Enroll Now</button>
    </form>
</div>
@else
<div style="background:#f0fdf4;border:1px solid #a7f3d0;border-radius:12px;padding:16px 24px;margin-bottom:20px;">
    <i class="fas fa-check-circle" style="color:#059669;"></i> <strong style="color:#065f46;">You are enrolled in this course!</strong>
</div>
@endif

<div class="grid-2">
    <!-- Videos -->
    <div class="card">
        <div class="card-title"><i class="fas fa-play-circle" style="color:#6366f1;"></i> Video Lessons</div>
        @forelse($course->videos as $video)
        <div style="display:flex;align-items:center;gap:12px;padding:12px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:8px;">
            <div style="width:36px;height:36px;background:#ede9fe;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-play" style="color:#6366f1;font-size:14px;"></i>
            </div>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:13px;">{{ $video->order_no }}. {{ $video->title }}</div>
                <div style="font-size:12px;color:#64748b;"><i class="fas fa-clock"></i> {{ $video->duration }}</div>
            </div>
            @if($enrolled)
            <a href="{{ $video->video_url }}" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-external-link-alt"></i></a>
            @else
            <i class="fas fa-lock" style="color:#94a3b8;"></i>
            @endif
        </div>
        @empty
        <p style="color:#94a3b8;font-size:14px;">No videos yet</p>
        @endforelse
    </div>

    <!-- Articles -->
    <div class="card">
        <div class="card-title"><i class="fas fa-file-alt" style="color:#059669;"></i> Articles / Notes</div>
        @forelse($course->articles as $article)
        <div style="padding:12px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:8px;">
            <div style="font-weight:600;font-size:13px;margin-bottom:4px;">{{ $article->order_no }}. {{ $article->title }}</div>
            @if($enrolled)
            <p style="font-size:13px;color:#64748b;line-height:1.5;">{{ Str::limit($article->content, 100) }}</p>
            @else
            <p style="font-size:13px;color:#94a3b8;"><i class="fas fa-lock"></i> Enroll to read</p>
            @endif
        </div>
        @empty
        <p style="color:#94a3b8;font-size:14px;">No articles yet</p>
        @endforelse
    </div>
</div>

<!-- Remedial Classes for this course -->
@if($course->remedialClasses->count() > 0)
<div class="card">
    <div class="card-title" style="color:#3b82f6;"><i class="fas fa-video"></i> My Remedial Classes for this Course</div>
    @foreach($course->remedialClasses as $rc)
    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:8px;">
        <div>
            <div style="font-weight:600;">{{ $rc->title }}</div>
            <div style="font-size:12px;color:#64748b;">{{ \Carbon\Carbon::parse($rc->scheduled_at)->format('M d, Y h:i A') }} | {{ $rc->platform }}</div>
        </div>
        <a href="{{ $rc->meeting_link }}" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-video"></i> Join</a>
    </div>
    @endforeach
</div>
@endif

<!-- Assignments for this course -->
@if($course->assignments->count() > 0)
<div class="card">
    <div class="card-title" style="color:#d97706;"><i class="fas fa-tasks"></i> My Assignments for this Course</div>
    @foreach($course->assignments as $a)
    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:8px;">
        <div>
            <div style="font-weight:600;">{{ $a->title }}</div>
            <div style="font-size:12px;color:#64748b;">Due: {{ $a->due_date->format('M d, Y') }} | {{ $a->marks }} marks</div>
        </div>
        <span class="badge {{ $a->status === 'graded' ? 'badge-success' : ($a->status === 'submitted' ? 'badge-info' : 'badge-warning') }}">{{ ucfirst($a->status) }}</span>
    </div>
    @endforeach
</div>
@endif
@endsection
