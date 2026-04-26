@extends('layouts.teacher')
@section('title', 'My Students')
@section('page-title', 'My Students')

@section('content')
<div class="table-container">
    <table>
        <thead><tr><th>Student</th><th>Roll No</th><th>Department</th><th>Semester</th><th>Last Score</th><th>Status</th></tr></thead>
        <tbody>
            @forelse($students as $s)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $s->user->name }}</div>
                    <div style="font-size:12px;color:#64748b;">{{ $s->user->email }}</div>
                </td>
                <td>{{ $s->roll_no }}</td>
                <td>{{ $s->department }}</td>
                <td>{{ $s->semester }}</td>
                <td>
                    @if($s->latestResult)
                        <span class="badge {{ $s->latestResult->percentage < 40 ? 'badge-danger' : ($s->latestResult->percentage <= 70 ? 'badge-warning' : 'badge-success') }}">
                            {{ $s->latestResult->percentage }}%
                        </span>
                    @else
                        <span class="badge badge-info">Not Tested</span>
                    @endif
                </td>
                <td>
                    @if(isset($s->latestResult))
                        @if($s->latestResult->status === 'slow_learner')
                            <span class="badge badge-danger">Slow Learner</span>
                        @elseif($s->latestResult->status === 'intermediate')
                            <span class="badge badge-warning">Intermediate</span>
                        @else
                            <span class="badge badge-success">Advanced</span>
                        @endif
                    @else
                        <span class="badge badge-info">Pending</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:48px;">No students assigned yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
