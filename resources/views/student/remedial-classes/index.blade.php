@extends('layouts.student')
@section('title', 'Remedial Classes')
@section('page-title', 'My Remedial Classes')

@section('content')
<!-- Upcoming Classes -->
<div class="card" style="margin-bottom:24px;">
    <div class="card-title" style="color:#3b82f6;"><i class="fas fa-video"></i> Upcoming Classes ({{ $upcomingClasses->count() }})</div>

    @forelse($upcomingClasses as $class)
    <div style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border-radius:16px;padding:20px 24px;margin-bottom:12px;border:1px solid #bfdbfe;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;flex-wrap:wrap;gap:10px;">
            <div>
                <div style="font-size:16px;font-weight:700;color:#1e293b;margin-bottom:4px;">{{ $class->title }}</div>
                <div style="font-size:13px;color:#64748b;">
                    <i class="fas fa-chalkboard-teacher" style="color:#3b82f6;"></i> {{ $class->teacher->user->name }} &nbsp;
                    <i class="fas fa-book" style="color:#6366f1;"></i> {{ $class->course->title }}
                </div>
                <div style="font-size:13px;color:#64748b;margin-top:4px;">
                    <i class="fas fa-calendar" style="color:#3b82f6;"></i> {{ \Carbon\Carbon::parse($class->scheduled_at)->format('M d, Y - h:i A') }} &nbsp;
                    <i class="fas fa-hourglass-half" style="color:#3b82f6;"></i> {{ $class->duration }} min
                </div>
            </div>
            <div>
                @if($class->status === 'live')
                    <span class="badge badge-danger" style="font-size:13px;padding:6px 14px;">🔴 LIVE NOW</span>
                @else
                    <span class="badge badge-info" style="font-size:13px;padding:6px 14px;">Upcoming</span>
                @endif
            </div>
        </div>

        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            @if(isset($attendances[$class->id]) && $attendances[$class->id] === 'joined')
                <span class="badge badge-success" style="font-size:13px;padding:8px 16px;"><i class="fas fa-check"></i> Joined</span>
            @else
                <form action="{{ route('student.class.join', $class->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fas fa-sign-in-alt"></i> Join & Mark Attendance</button>
                </form>
            @endif
            <a href="{{ $class->meeting_link }}" target="_blank" class="btn btn-primary"><i class="fas fa-video"></i> {{ $class->platform }}</a>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:32px;color:#94a3b8;">
        <i class="fas fa-calendar-check" style="font-size:36px;color:#e2e8f0;display:block;margin-bottom:8px;"></i>
        No upcoming classes scheduled
    </div>
    @endforelse
</div>

<!-- Completed Classes -->
@if($completedClasses->count() > 0)
<div class="card">
    <div class="card-title" style="color:#059669;"><i class="fas fa-check-circle"></i> Completed Classes</div>
    <div class="table-container">
        <table>
            <thead><tr><th>Title</th><th>Course</th><th>Teacher</th><th>Date</th><th>Attendance</th></tr></thead>
            <tbody>
                @foreach($completedClasses as $class)
                <tr>
                    <td style="font-weight:600;">{{ $class->title }}</td>
                    <td>{{ $class->course->title }}</td>
                    <td>{{ $class->teacher->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($class->scheduled_at)->format('M d, Y') }}</td>
                    <td>
                        @if(isset($attendances[$class->id]))
                            <span class="badge badge-success"><i class="fas fa-check"></i> Present</span>
                        @else
                            <span class="badge badge-danger">Absent</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
