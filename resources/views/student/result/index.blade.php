@extends('layouts.student')
@section('title', 'My Results')
@section('page-title', 'My Test Results')

@section('content')
@if($latestResult)
<!-- Latest Result Card -->
<div style="background:linear-gradient(135deg,{{ $latestResult->status === 'slow_learner' ? '#fef2f2,#fee2e2' : ($latestResult->status === 'intermediate' ? '#fffbeb,#fef3c7' : '#f0fdf4,#dcfce7') }});border-radius:20px;padding:32px;margin-bottom:28px;border:1px solid {{ $latestResult->status === 'slow_learner' ? '#fecaca' : ($latestResult->status === 'intermediate' ? '#fcd34d' : '#a7f3d0') }};">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="font-size:13px;color:#64748b;font-weight:500;margin-bottom:4px;">Latest Result — {{ $latestResult->assessment->title }}</div>
            <div style="font-size:48px;font-weight:800;color:{{ $latestResult->status === 'slow_learner' ? '#dc2626' : ($latestResult->status === 'intermediate' ? '#d97706' : '#059669') }};line-height:1;">
                {{ $latestResult->percentage }}%
            </div>
            <div style="font-size:14px;color:#64748b;margin-top:8px;">Score: {{ $latestResult->score }} / {{ $latestResult->total_marks }}</div>
        </div>
        <div style="text-align:right;">
            <div style="margin-bottom:12px;">
                @if($latestResult->status === 'slow_learner')
                    <span style="background:#dc2626;color:#fff;padding:8px 20px;border-radius:9999px;font-size:14px;font-weight:700;">⚠️ Slow Learner</span>
                @elseif($latestResult->status === 'intermediate')
                    <span style="background:#d97706;color:#fff;padding:8px 20px;border-radius:9999px;font-size:14px;font-weight:700;">📚 Intermediate</span>
                @else
                    <span style="background:#059669;color:#fff;padding:8px 20px;border-radius:9999px;font-size:14px;font-weight:700;">🏆 Advanced</span>
                @endif
            </div>
            <div style="font-size:13px;color:#64748b;">Skill Level: <strong>{{ ucfirst($latestResult->skill_level) }}</strong></div>
            <div style="font-size:13px;color:#64748b;">Category: {{ $latestResult->assessment->category }}</div>
        </div>
    </div>

    <!-- Score Bar -->
    <div style="margin-top:24px;">
        <div style="background:rgba(0,0,0,0.08);border-radius:9999px;height:14px;overflow:hidden;">
            <div style="width:{{ $latestResult->percentage }}%;height:100%;background:{{ $latestResult->status === 'slow_learner' ? 'linear-gradient(90deg,#dc2626,#f87171)' : ($latestResult->status === 'intermediate' ? 'linear-gradient(90deg,#d97706,#fbbf24)' : 'linear-gradient(90deg,#059669,#34d399)') }};border-radius:9999px;transition:width 1s;"></div>
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:6px;font-size:12px;color:#64748b;">
            <span>0%</span><span style="color:#dc2626;">40% (Slow Learner)</span><span style="color:#d97706;">70%</span><span style="color:#059669;">100%</span>
        </div>
    </div>

    @if($latestResult->status === 'slow_learner')
    <div style="margin-top:20px;padding:16px;background:rgba(220,38,38,0.08);border-radius:12px;border-left:4px solid #dc2626;">
        <p style="color:#991b1b;font-size:14px;"><i class="fas fa-lightbulb"></i> <strong>Recommendation:</strong> Personalized beginner courses have been assigned to help you improve. Check your <a href="{{ route('student.recommended-courses') }}" style="color:#6366f1;font-weight:600;">Recommended Courses</a> to get started!</p>
    </div>
    @endif
</div>
@endif

<!-- All Results History -->
<div class="card">
    <div class="card-title"><i class="fas fa-history" style="color:#6366f1;"></i> Assessment History</div>
    <div class="table-container">
        <table>
            <thead><tr><th>Assessment</th><th>Category</th><th>Score</th><th>Percentage</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($results as $r)
                <tr>
                    <td style="font-weight:600;">{{ $r->assessment->title }}</td>
                    <td>{{ $r->assessment->category }}</td>
                    <td>{{ $r->score }} / {{ $r->total_marks }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="flex:1;background:#e2e8f0;border-radius:9999px;height:8px;width:80px;overflow:hidden;">
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
                <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:48px;">
                    <i class="fas fa-clipboard-list" style="font-size:40px;display:block;margin-bottom:8px;color:#e2e8f0;"></i>
                    No assessments taken yet. <a href="{{ route('student.assessment.start') }}" style="color:#6366f1;">Take your first test</a>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
