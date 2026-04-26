@extends('layouts.admin')
@section('title', 'Progress Reports')
@section('page-title', 'Student Progress Reports')

@section('content')
<div class="page-header">
    <h1 class="page-title">Progress Reports</h1>
    <div style="display:flex;gap:8px;">
        <span class="badge badge-success" style="font-size:13px;padding:8px 16px;">Improved: {{ $reports->where('status','Improved')->count() }}</span>
        <span class="badge badge-warning" style="font-size:13px;padding:8px 16px;">Stagnant: {{ $reports->where('status','Stagnant')->count() }}</span>
        <span class="badge badge-danger" style="font-size:13px;padding:8px 16px;">Declined: {{ $reports->where('status','Declined')->count() }}</span>
    </div>
</div>

<div class="grid-3">
    @forelse($reports as $report)
    <div class="stat-card" style="border-left:4px solid {{ $report->status === 'Improved' ? '#059669' : ($report->status === 'Declined' ? '#dc2626' : '#d97706') }};">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
            <div>
                <div style="font-size:16px;font-weight:700;color:#1e293b;">{{ $report->student->user->name }}</div>
                <div style="font-size:13px;color:#64748b;">{{ $report->course->title }}</div>
                <div style="font-size:12px;color:#94a3b8;">By: {{ $report->teacher->user->name }}</div>
            </div>
            <span class="badge {{ $report->status === 'Improved' ? 'badge-success' : ($report->status === 'Declined' ? 'badge-danger' : 'badge-warning') }}">
                {{ $report->status }}
            </span>
        </div>

        <!-- Progress Bar -->
        <div style="margin-bottom:12px;">
            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                <span style="font-size:12px;color:#64748b;">Initial: {{ $report->initial_score }}%</span>
                <span style="font-size:12px;color:#64748b;">Current: {{ $report->current_score }}%</span>
            </div>
            <div style="background:#e2e8f0;border-radius:9999px;height:10px;overflow:hidden;">
                <div style="width:{{ min($report->initial_score, 100) }}%;height:100%;background:#94a3b8;border-radius:9999px;"></div>
            </div>
            <div style="background:#e2e8f0;border-radius:9999px;height:10px;overflow:hidden;margin-top:4px;">
                <div style="width:{{ min($report->current_score, 100) }}%;height:100%;background:{{ $report->status === 'Improved' ? '#059669' : ($report->status === 'Declined' ? '#dc2626' : '#d97706') }};border-radius:9999px;transition:width 1s;"></div>
            </div>
        </div>

        <div style="font-size:13px;color:#475569;">
            <i class="fas fa-chart-line" style="color:#6366f1;"></i>
            Progress: <strong>{{ $report->progress_percentage > 0 ? '+' : '' }}{{ $report->progress_percentage }}%</strong>
        </div>
        @if($report->remarks)
        <div style="margin-top:8px;font-size:12px;color:#64748b;font-style:italic;">{{ $report->remarks }}</div>
        @endif
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;color:#94a3b8;padding:48px;">
        <i class="fas fa-chart-line" style="font-size:48px;margin-bottom:12px;display:block;color:#e2e8f0;"></i>
        No progress reports yet
    </div>
    @endforelse
</div>
@endsection
