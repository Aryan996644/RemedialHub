@extends('layouts.teacher')
@section('title', 'Test Results')
@section('page-title', 'Student Test Results')

@section('content')
<div class="table-container">
    <table>
        <thead><tr><th>Student</th><th>Assessment</th><th>Score</th><th>Total</th><th>Percentage</th><th>Skill Level</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($results as $r)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $r->student->user->name }}</div>
                    <div style="font-size:12px;color:#64748b;">{{ $r->student->roll_no }}</div>
                </td>
                <td>{{ $r->assessment->title }}</td>
                <td>{{ $r->score }}</td>
                <td>{{ $r->total_marks }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="flex:1;background:#e2e8f0;border-radius:9999px;height:8px;width:80px;">
                            <div style="width:{{ $r->percentage }}%;height:100%;background:{{ $r->percentage < 40 ? '#dc2626' : ($r->percentage <= 70 ? '#d97706' : '#059669') }};border-radius:9999px;"></div>
                        </div>
                        <span style="font-weight:600;color:{{ $r->percentage < 40 ? '#dc2626' : ($r->percentage <= 70 ? '#d97706' : '#059669') }};">{{ $r->percentage }}%</span>
                    </div>
                </td>
                <td><span class="badge badge-purple">{{ ucfirst($r->skill_level) }}</span></td>
                <td>
                    @if($r->status === 'slow_learner')<span class="badge badge-danger">Slow Learner</span>
                    @elseif($r->status === 'intermediate')<span class="badge badge-warning">Intermediate</span>
                    @else<span class="badge badge-success">Advanced</span>@endif
                </td>
                <td style="color:#64748b;font-size:13px;">{{ $r->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#94a3b8;padding:32px;">No results yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
