@extends('layouts.teacher')
@section('title', 'Submissions')
@section('page-title', 'Student Submissions')

@section('content')
@forelse($submissions as $sub)
<div class="card" style="margin-bottom:20px;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
        <div>
            <div style="font-size:16px;font-weight:700;color:#1e293b;">{{ $sub->assignment->title }}</div>
            <div style="font-size:13px;color:#6366f1;margin-top:2px;">{{ $sub->assignment->course->title }}</div>
            <div style="font-size:13px;color:#64748b;margin-top:4px;">
                <i class="fas fa-user"></i> <strong>{{ $sub->student->user->name }}</strong> &nbsp;
                <i class="fas fa-calendar"></i> Submitted: {{ $sub->submitted_at ? \Carbon\Carbon::parse($sub->submitted_at)->format('M d, Y h:i A') : 'N/A' }} &nbsp;
                <i class="fas fa-star"></i> Max: {{ $sub->assignment->marks }} marks
            </div>
        </div>
        @if($sub->status === 'graded')
            <span class="badge badge-success" style="font-size:14px;padding:8px 16px;">
                Graded: {{ $sub->obtained_marks }} / {{ $sub->assignment->marks }}
            </span>
        @else
            <span class="badge badge-warning">Pending Grading</span>
        @endif
    </div>

    <div style="background:#f8fafc;border-radius:10px;padding:16px;margin-bottom:16px;">
        <div style="font-size:13px;font-weight:600;color:#64748b;margin-bottom:8px;"><i class="fas fa-file-alt"></i> Student's Answer:</div>
        <p style="font-size:14px;color:#1e293b;line-height:1.6;">{{ $sub->answer_text }}</p>
        @if($sub->file_path)
        <a href="{{ asset('storage/' . $sub->file_path) }}" target="_blank" class="btn btn-primary btn-sm" style="margin-top:8px;"><i class="fas fa-download"></i> Download File</a>
        @endif
    </div>

    @if($sub->feedback)
    <div style="background:#dcfce7;border-radius:10px;padding:12px;margin-bottom:12px;">
        <div style="font-size:13px;font-weight:600;color:#166534;"><i class="fas fa-comment-dots"></i> Feedback:</div>
        <p style="font-size:13px;color:#166534;margin-top:4px;">{{ $sub->feedback }}</p>
    </div>
    @endif

    @if($sub->status !== 'graded')
    <form action="{{ route('teacher.submissions.grade', $sub->id) }}" method="POST">
        @csrf
        <div style="display:grid;grid-template-columns:200px 1fr auto;gap:12px;align-items:flex-end;">
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Marks Obtained (Max: {{ $sub->assignment->marks }})</label>
                <input type="number" name="obtained_marks" class="form-input" required min="0" max="{{ $sub->assignment->marks }}" placeholder="0">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Feedback (optional)</label>
                <input type="text" name="feedback" class="form-input" placeholder="Write feedback for student...">
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Grade</button>
        </div>
    </form>
    @endif
</div>
@empty
<div style="text-align:center;padding:64px;background:#fff;border-radius:16px;border:1px solid #e2e8f0;">
    <i class="fas fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px;"></i>
    <p style="color:#64748b;font-size:16px;">No submissions yet</p>
</div>
@endforelse
@endsection
