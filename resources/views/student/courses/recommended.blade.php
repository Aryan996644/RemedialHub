@extends('layouts.student')
@section('title', 'Recommended Courses')
@section('page-title', 'Recommended Courses')

@section('content')
@if($recommendations->isEmpty())
<div style="text-align:center;padding:64px;background:#fff;border-radius:20px;border:1px solid #e2e8f0;">
    <div style="width:72px;height:72px;background:#ede9fe;border-radius:20px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;">
        <i class="fas fa-star" style="color:#6366f1;font-size:32px;"></i>
    </div>
    <h3 style="font-size:20px;font-weight:700;color:#1e293b;margin-bottom:8px;">No Recommendations Yet</h3>
    <p style="color:#64748b;margin-bottom:24px;">Take a skill assessment to get personalized course recommendations.</p>
    <a href="{{ route('student.assessment.start') }}" class="btn btn-primary"><i class="fas fa-play"></i> Take Assessment</a>
</div>
@else
<div style="margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
    <p style="color:#64748b;font-size:15px;"><i class="fas fa-magic" style="color:#6366f1;"></i> {{ $recommendations->count() }} course(s) recommended based on your assessment</p>
</div>

<div class="grid-3">
    @foreach($recommendations as $rec)
    <div style="background:#fff;border-radius:20px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all 0.3s;display:flex;flex-direction:column;">
        <!-- Course Level Banner -->
        <div style="padding:20px 24px;background:{{ $rec->course->level === 'beginner' ? 'linear-gradient(135deg,#059669,#10b981)' : ($rec->course->level === 'intermediate' ? 'linear-gradient(135deg,#d97706,#f59e0b)' : 'linear-gradient(135deg,#6366f1,#8b5cf6)') }};color:#fff;">
            <div style="font-size:12px;opacity:0.85;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">{{ ucfirst($rec->course->level) }} Level</div>
            <div style="font-size:18px;font-weight:700;line-height:1.3;">{{ $rec->course->title }}</div>
            <div style="font-size:13px;opacity:0.85;margin-top:4px;">{{ $rec->course->category }}</div>
        </div>

        <div style="padding:20px 24px;flex:1;display:flex;flex-direction:column;">
            <p style="font-size:13px;color:#64748b;line-height:1.6;margin-bottom:16px;flex:1;">{{ Str::limit($rec->course->description, 100) }}</p>

            <!-- Stats -->
            <div style="display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap;">
                <span style="font-size:12px;color:#64748b;"><i class="fas fa-play-circle" style="color:#6366f1;"></i> {{ $rec->course->videos_count }} videos</span>
                <span style="font-size:12px;color:#64748b;"><i class="fas fa-file-alt" style="color:#059669;"></i> {{ $rec->course->articles_count }} articles</span>
                <span style="font-size:12px;color:#64748b;"><i class="fas fa-clock" style="color:#d97706;"></i> {{ $rec->course->duration }}</span>
            </div>

            <!-- Teacher -->
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                <div style="width:28px;height:28px;background:#ede9fe;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-chalkboard-teacher" style="color:#6366f1;font-size:12px;"></i>
                </div>
                <span style="font-size:13px;color:#64748b;">{{ $rec->course->teacher->user->name }}</span>
            </div>

            <!-- Reason -->
            <div style="background:#f0fdf4;border-radius:8px;padding:10px;margin-bottom:16px;border-left:3px solid #059669;">
                <p style="font-size:12px;color:#166534;"><i class="fas fa-lightbulb"></i> {{ $rec->reason }}</p>
            </div>

            <!-- Actions -->
            <div style="display:flex;gap:8px;">
                <a href="{{ route('student.courses.show', $rec->course->id) }}" class="btn btn-primary" style="flex:1;justify-content:center;"><i class="fas fa-eye"></i> View</a>
                <form action="{{ route('student.enroll') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $rec->course->id }}">
                    <button type="submit" class="btn btn-success"><i class="fas fa-graduation-cap"></i> Enroll</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
