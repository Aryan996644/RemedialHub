@extends('layouts.teacher')
@section('title', 'Slow Learners')
@section('page-title', 'Slow Learner Management')

@section('content')
<div style="background:linear-gradient(135deg,#fef2f2,#fee2e2);border:1px solid #fecaca;border-radius:16px;padding:20px 24px;margin-bottom:24px;display:flex;align-items:center;gap:16px;">
    <div style="width:48px;height:48px;background:#dc2626;border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-exclamation-triangle" style="color:#fff;font-size:20px;"></i>
    </div>
    <div>
        <div style="font-size:18px;font-weight:700;color:#991b1b;">{{ $slowLearners->count() }} Slow Learners Identified</div>
        <div style="color:#b91c1c;font-size:14px;">Score below 40% — Remedial support required</div>
    </div>
</div>

<div class="table-container">
    <table>
        <thead><tr><th>Student</th><th>Assessment</th><th>Score</th><th>Percentage</th><th>Category</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($slowLearners as $r)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $r->student->user->name }}</div>
                    <div style="font-size:12px;color:#64748b;">{{ $r->student->department }} | {{ $r->student->roll_no }}</div>
                </td>
                <td>{{ $r->assessment->title }}</td>
                <td>{{ $r->score }} / {{ $r->total_marks }}</td>
                <td><span class="badge badge-danger">{{ $r->percentage }}%</span></td>
                <td><span class="badge badge-purple">{{ $r->assessment->category }}</span></td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('teacher.remedial-classes') }}" class="btn btn-primary btn-sm"><i class="fas fa-video"></i> Schedule Class</a>
                        <a href="{{ route('teacher.assignments') }}" class="btn btn-warning btn-sm"><i class="fas fa-tasks"></i> Assign Task</a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:48px;">
                <i class="fas fa-check-circle" style="font-size:48px;color:#059669;display:block;margin-bottom:8px;"></i>
                No slow learners. All students are performing well!
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
