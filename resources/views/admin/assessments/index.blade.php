@extends('layouts.admin')
@section('title', 'Assessments')
@section('page-title', 'Assessment Overview')

@section('content')
<div class="page-header">
    <h1 class="page-title">All Assessments</h1>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr><th>Title</th><th>Teacher</th><th>Category</th><th>Questions</th><th>Attempts</th><th>Avg Score</th><th>Status</th></tr>
        </thead>
        <tbody>
            @forelse($assessments as $assessment)
            <tr>
                <td style="font-weight:600;">{{ $assessment->title }}</td>
                <td>{{ $assessment->teacher->user->name }}</td>
                <td>{{ $assessment->category }}</td>
                <td><span class="badge badge-info">{{ $assessment->questions_count }} Qs</span></td>
                <td><span class="badge badge-purple">{{ $assessment->results_count }}</span></td>
                <td>
                    <span class="badge {{ $assessment->avg_score < 40 ? 'badge-danger' : ($assessment->avg_score <= 70 ? 'badge-warning' : 'badge-success') }}">
                        {{ $assessment->avg_score }}%
                    </span>
                </td>
                <td>
                    @if($assessment->status === 'active')<span class="badge badge-success">Active</span>
                    @else<span class="badge badge-danger">Inactive</span>@endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:32px;">No assessments found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
