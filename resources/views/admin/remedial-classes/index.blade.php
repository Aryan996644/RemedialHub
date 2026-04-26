@extends('layouts.admin')
@section('title', 'Remedial Classes')
@section('page-title', 'Remedial Video Classes')

@section('content')
<div class="page-header">
    <h1 class="page-title">All Remedial Classes</h1>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr><th>Title</th><th>Teacher</th><th>Student</th><th>Course</th><th>Platform</th><th>Scheduled</th><th>Duration</th><th>Status</th></tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
            <tr>
                <td style="font-weight:600;">{{ $class->title }}</td>
                <td>{{ $class->teacher->user->name }}</td>
                <td>{{ $class->student->user->name }}</td>
                <td>{{ $class->course->title }}</td>
                <td>
                    @if($class->platform === 'Google Meet')
                        <span class="badge badge-success"><i class="fas fa-video"></i> Google Meet</span>
                    @elseif($class->platform === 'Zoom')
                        <span class="badge badge-info"><i class="fas fa-video"></i> Zoom</span>
                    @else
                        <span class="badge badge-purple"><i class="fas fa-link"></i> Custom</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($class->scheduled_at)->format('M d, Y h:i A') }}</td>
                <td>{{ $class->duration }} min</td>
                <td>
                    @if($class->status === 'upcoming')<span class="badge badge-info">Upcoming</span>
                    @elseif($class->status === 'live')<span class="badge badge-danger">🔴 Live</span>
                    @elseif($class->status === 'completed')<span class="badge badge-success">Completed</span>
                    @else<span class="badge badge-warning">Cancelled</span>@endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#94a3b8;padding:32px;">No remedial classes scheduled</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
