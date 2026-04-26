@extends('layouts.admin')
@section('title', 'Assignments')
@section('page-title', 'Assignments Overview')

@section('content')
<div class="page-header">
    <h1 class="page-title">All Assignments</h1>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr><th>Title</th><th>Course</th><th>Teacher</th><th>Student</th><th>Due Date</th><th>Marks</th><th>Status</th></tr>
        </thead>
        <tbody>
            @forelse($assignments as $assignment)
            <tr>
                <td style="font-weight:600;">{{ $assignment->title }}</td>
                <td>{{ $assignment->course->title }}</td>
                <td>{{ $assignment->teacher->user->name }}</td>
                <td>{{ $assignment->student->user->name }}</td>
                <td>
                    <span style="{{ \Carbon\Carbon::parse($assignment->due_date)->isPast() ? 'color:#dc2626;font-weight:600;' : '' }}">
                        {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                    </span>
                </td>
                <td>{{ $assignment->marks }}</td>
                <td>
                    @if($assignment->status === 'pending')<span class="badge badge-warning">Pending</span>
                    @elseif($assignment->status === 'submitted')<span class="badge badge-info">Submitted</span>
                    @else<span class="badge badge-success">Graded</span>@endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:32px;">No assignments found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
