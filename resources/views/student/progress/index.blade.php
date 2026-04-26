@extends('layouts.student')
@section('title', 'My Progress')
@section('page-title', 'My Learning Progress')

@section('content')
<!-- Summary Cards -->
<div class="grid-4" style="margin-bottom:24px;">
    <div class="stat-card" style="text-align:center;">
        <div style="width:52px;height:52px;background:#ede9fe;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
            <i class="fas fa-book-open" style="color:#6366f1;font-size:22px;"></i>
        </div>
        <div style="font-size:28px;font-weight:800;color:#6366f1;">{{ $enrollments }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:4px;">Courses Enrolled</div>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="width:52px;height:52px;background:#dcfce7;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
            <i class="fas fa-video" style="color:#059669;font-size:22px;"></i>
        </div>
        <div style="font-size:28px;font-weight:800;color:#059669;">{{ $classesJoined }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:4px;">Classes Attended</div>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="width:52px;height:52px;background:#fef3c7;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
            <i class="fas fa-paper-plane" style="color:#d97706;font-size:22px;"></i>
        </div>
        <div style="font-size:28px;font-weight:800;color:#d97706;">{{ $assignmentsSubmitted }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:4px;">Assignments Done</div>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="width:52px;height:52px;background:#dbeafe;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
            <i class="fas fa-clipboard-check" style="color:#3b82f6;font-size:22px;"></i>
        </div>
        <div style="font-size:28px;font-weight:800;color:#3b82f6;">{{ $results->count() }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:4px;">Tests Taken</div>
    </div>
</div>

<!-- Progress Reports -->
@if($reports->count() > 0)
<div class="card" style="margin-bottom:24px;">
    <div class="card-title"><i class="fas fa-chart-line" style="color:#059669;"></i> Progress Reports from Teacher</div>
    <div class="grid-2">
        @foreach($reports as $report)
        <div style="background:#fff;border-radius:14px;padding:20px;border:1px solid #e2e8f0;border-top:4px solid {{ $report->status === 'Improved' ? '#059669' : ($report->status === 'Declined' ? '#dc2626' : '#d97706') }};">
            <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
                <div>
                    <div style="font-weight:700;color:#1e293b;">{{ $report->course->title }}</div>
                    <div style="font-size:12px;color:#64748b;">By {{ $report->teacher->user->name }}</div>
                </div>
                <span class="badge {{ $report->status === 'Improved' ? 'badge-success' : ($report->status === 'Declined' ? 'badge-danger' : 'badge-warning') }}">{{ $report->status }}</span>
            </div>
            <div style="margin-bottom:10px;">
                <div style="display:flex;justify-content:space-between;font-size:12px;color:#64748b;margin-bottom:4px;">
                    <span>Initial: {{ $report->initial_score }}%</span>
                    <span>Current: {{ $report->current_score }}%</span>
                </div>
                <div style="background:#e2e8f0;border-radius:9999px;height:10px;overflow:hidden;">
                    <div style="width:{{ min($report->current_score, 100) }}%;height:100%;background:{{ $report->status === 'Improved' ? 'linear-gradient(90deg,#059669,#34d399)' : ($report->status === 'Declined' ? '#dc2626' : '#d97706') }};border-radius:9999px;"></div>
                </div>
            </div>
            <div style="font-size:13px;font-weight:600;color:{{ $report->status === 'Improved' ? '#059669' : ($report->status === 'Declined' ? '#dc2626' : '#d97706') }};">
                {{ $report->progress_percentage > 0 ? '+' : '' }}{{ $report->progress_percentage }}% progress
            </div>
            @if($report->remarks)
            <p style="font-size:12px;color:#64748b;font-style:italic;margin-top:8px;">{{ $report->remarks }}</p>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Test History -->
<div class="card">
    <div class="card-title"><i class="fas fa-history" style="color:#6366f1;"></i> Assessment Performance History</div>
    <div class="table-container">
        <table>
            <thead><tr><th>Assessment</th><th>Score</th><th>Percentage</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($results as $r)
                <tr>
                    <td style="font-weight:600;">{{ $r->assessment->title }}</td>
                    <td>{{ $r->score }} / {{ $r->total_marks }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:80px;background:#e2e8f0;border-radius:9999px;height:8px;overflow:hidden;">
                                <div style="width:{{ $r->percentage }}%;height:100%;background:{{ $r->percentage < 40 ? '#dc2626' : ($r->percentage <= 70 ? '#d97706' : '#059669') }};border-radius:9999px;"></div>
                            </div>
                            <span style="font-weight:600;color:{{ $r->percentage < 40 ? '#dc2626' : ($r->percentage <= 70 ? '#d97706' : '#059669') }};">{{ $r->percentage }}%</span>
                        </div>
                    </td>
                    <td>
                        @if($r->status === 'slow_learner')<span class="badge badge-danger">Slow Learner</span>
                        @elseif($r->status === 'intermediate')<span class="badge badge-warning">Intermediate</span>
                        @else<span class="badge badge-success">Advanced</span>@endif
                    </td>
                    <td style="color:#64748b;font-size:13px;">{{ $r->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:32px;">No tests taken yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
