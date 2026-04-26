@extends('layouts.student')
@section('title', 'Video Lessons')
@section('page-title', 'My Video Lessons')

@section('content')
@if($videos->isEmpty())
<div style="text-align:center;padding:64px;background:#fff;border-radius:20px;border:1px solid #e2e8f0;">
    <i class="fas fa-play-circle" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px;"></i>
    <p style="color:#64748b;margin-bottom:16px;">No video lessons available. Enroll in a course first.</p>
    <a href="{{ route('student.recommended-courses') }}" class="btn btn-primary">Browse Recommended Courses</a>
</div>
@else
<div style="display:flex;flex-direction:column;gap:16px;">
    @php $currentCourse = null; @endphp
    @foreach($videos as $video)
        @if($currentCourse !== $video->course_id)
            @if($currentCourse !== null) </div> @endif
            <div style="font-size:16px;font-weight:700;color:#1e293b;margin-top:8px;padding:0 4px;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-book-open" style="color:#6366f1;"></i> {{ $video->course->title }}
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;">
            @php $currentCourse = $video->course_id; @endphp
        @endif

        <div style="background:#fff;border-radius:14px;padding:18px 20px;border:1px solid #e2e8f0;display:flex;align-items:center;gap:16px;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
            <div style="width:52px;height:52px;background:linear-gradient(135deg,#ede9fe,#c7d2fe);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="font-weight:800;color:#6366f1;font-size:16px;">{{ $video->order_no }}</span>
            </div>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:15px;color:#1e293b;margin-bottom:4px;">{{ $video->title }}</div>
                <div style="display:flex;gap:16px;">
                    <span style="font-size:13px;color:#64748b;"><i class="fas fa-clock" style="color:#6366f1;"></i> {{ $video->duration }}</span>
                    <span style="font-size:13px;color:#64748b;"><i class="fas fa-book" style="color:#059669;"></i> {{ $video->course->title }}</span>
                </div>
            </div>
            <a href="{{ $video->video_url }}" target="_blank" class="btn btn-primary" style="flex-shrink:0;">
                <i class="fas fa-play"></i> Watch
            </a>
        </div>
    @endforeach
    </div>
</div>
@endif
@endsection
