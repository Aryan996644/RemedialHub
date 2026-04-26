@extends('layouts.student')
@section('title', 'Assignments')
@section('page-title', 'My Assignments')

@section('content')
@forelse($assignments as $assignment)
<div class="card" style="margin-bottom:20px;border-left:4px solid {{ $assignment->status === 'graded' ? '#059669' : ($assignment->status === 'submitted' ? '#3b82f6' : '#d97706') }};">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
        <div>
            <div style="font-size:17px;font-weight:700;color:#1e293b;">{{ $assignment->title }}</div>
            <div style="font-size:13px;color:#6366f1;margin-top:2px;"><i class="fas fa-book"></i> {{ $assignment->course->title }}</div>
            <div style="font-size:13px;color:#64748b;margin-top:4px;">
                <i class="fas fa-calendar" style="color:{{ \Carbon\Carbon::parse($assignment->due_date)->isPast() && $assignment->status === 'pending' ? '#dc2626' : '#d97706' }};"></i>
                Due: <strong style="color:{{ \Carbon\Carbon::parse($assignment->due_date)->isPast() && $assignment->status === 'pending' ? '#dc2626' : '#1e293b' }};">{{ $assignment->due_date->format('M d, Y') }}</strong>
                &nbsp;<i class="fas fa-star" style="color:#d97706;"></i> {{ $assignment->marks }} marks
            </div>
        </div>
        @if($assignment->status === 'graded')
            <span class="badge badge-success" style="font-size:14px;padding:8px 16px;">
                ✓ Graded: {{ $assignment->latestSubmission ? $assignment->latestSubmission->obtained_marks : '-' }} / {{ $assignment->marks }}
            </span>
        @elseif($assignment->status === 'submitted')
            <span class="badge badge-info" style="font-size:14px;padding:8px 16px;">✓ Submitted</span>
        @else
            <span class="badge badge-warning" style="font-size:14px;padding:8px 16px;">Pending</span>
        @endif
    </div>

    @if($assignment->description)
    <div style="background:#f8fafc;border-radius:10px;padding:14px;margin-bottom:16px;">
        <div style="font-size:12px;font-weight:600;color:#64748b;margin-bottom:6px;"><i class="fas fa-info-circle"></i> Instructions:</div>
        <p style="font-size:14px;color:#334155;line-height:1.6;">{{ $assignment->description }}</p>
    </div>
    @endif

    <!-- Graded Feedback -->
    @if($assignment->latestSubmission && $assignment->latestSubmission->feedback)
    <div style="background:#dcfce7;border-radius:10px;padding:14px;margin-bottom:16px;">
        <div style="font-size:12px;font-weight:600;color:#166534;margin-bottom:6px;"><i class="fas fa-comment-dots"></i> Teacher Feedback:</div>
        <p style="font-size:14px;color:#166534;">{{ $assignment->latestSubmission->feedback }}</p>
    </div>
    @endif

    <!-- Submit Form (only if pending) -->
    @if($assignment->status === 'pending')
    <form action="{{ route('student.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Your Answer</label>
            <textarea name="answer_text" class="form-input" rows="5" required placeholder="Write your answer here..."></textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Attach File (optional)</label>
            <input type="file" name="file" class="form-input">
        </div>
        <button type="submit" class="btn btn-primary" onclick="return confirm('Submit this assignment?')">
            <i class="fas fa-paper-plane"></i> Submit Assignment
        </button>
    </form>
    @endif
</div>
@empty
<div style="text-align:center;padding:64px;background:#fff;border-radius:20px;border:1px solid #e2e8f0;">
    <i class="fas fa-tasks" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px;"></i>
    <p style="color:#64748b;">No assignments yet</p>
</div>
@endforelse
@endsection
