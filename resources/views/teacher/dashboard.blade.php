@extends('layouts.teacher')
@section('title', 'Teacher Dashboard')
@section('page-title', 'My Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="grid-4">
    <div class="stat-card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div><div style="font-size:13px;color:#64748b;">My Students</div><div style="font-size:28px;font-weight:700;color:#1e293b;margin-top:4px;">{{ $myStudents }}</div></div>
            <div style="width:48px;height:48px;background:#dbeafe;border-radius:12px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-users" style="color:#3b82f6;font-size:20px;"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div><div style="font-size:13px;color:#64748b;">Courses Created</div><div style="font-size:28px;font-weight:700;color:#1e293b;margin-top:4px;">{{ $coursesCreated }}</div></div>
            <div style="width:48px;height:48px;background:#dcfce7;border-radius:12px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-book-open" style="color:#059669;font-size:20px;"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div><div style="font-size:13px;color:#64748b;">Tests Created</div><div style="font-size:28px;font-weight:700;color:#1e293b;margin-top:4px;">{{ $testsCreated }}</div></div>
            <div style="width:48px;height:48px;background:#fef3c7;border-radius:12px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-clipboard-check" style="color:#d97706;font-size:20px;"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div><div style="font-size:13px;color:#64748b;">Slow Learners</div><div style="font-size:28px;font-weight:700;color:#dc2626;margin-top:4px;">{{ $slowLearners }}</div></div>
            <div style="width:48px;height:48px;background:#fee2e2;border-radius:12px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-exclamation-triangle" style="color:#dc2626;font-size:20px;"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div><div style="font-size:13px;color:#64748b;">Upcoming Classes</div><div style="font-size:28px;font-weight:700;color:#1e293b;margin-top:4px;">{{ $upcomingClasses }}</div></div>
            <div style="width:48px;height:48px;background:#dbeafe;border-radius:12px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-video" style="color:#3b82f6;font-size:20px;"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div><div style="font-size:13px;color:#64748b;">Pending Submissions</div><div style="font-size:28px;font-weight:700;color:#1e293b;margin-top:4px;">{{ $pendingSubmissions }}</div></div>
            <div style="width:48px;height:48px;background:#fef3c7;border-radius:12px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-inbox" style="color:#d97706;font-size:20px;"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div><div style="font-size:13px;color:#64748b;">Average Score</div><div style="font-size:28px;font-weight:700;color:#6366f1;margin-top:4px;">{{ $avgScore }}%</div></div>
            <div style="width:48px;height:48px;background:#ede9fe;border-radius:12px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-chart-bar" style="color:#6366f1;font-size:20px;"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div><div style="font-size:13px;color:#64748b;">Improved Students</div><div style="font-size:28px;font-weight:700;color:#059669;margin-top:4px;">{{ $improvedStudents }}</div></div>
            <div style="width:48px;height:48px;background:#dcfce7;border-radius:12px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-arrow-trend-up" style="color:#059669;font-size:20px;"></i></div>
        </div>
    </div>
</div>

<!-- Bottom Sections -->
<div class="grid-2">
    <!-- Student Performance -->
    <div class="card">
        <div class="card-title"><i class="fas fa-poll" style="color:#6366f1;"></i> Student Performance</div>
        <div class="table-container">
            <table>
                <thead><tr><th>Student</th><th>Assessment</th><th>Score</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($studentPerformance as $result)
                    <tr>
                        <td style="font-weight:600;">{{ $result->student->user->name }}</td>
                        <td>{{ $result->assessment->title }}</td>
                        <td>{{ $result->percentage }}%</td>
                        <td>
                            @if($result->status === 'slow_learner')<span class="badge badge-danger">Slow Learner</span>
                            @elseif($result->status === 'intermediate')<span class="badge badge-warning">Intermediate</span>
                            @else<span class="badge badge-success">Advanced</span>@endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:#94a3b8;">No results yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Slow Learner Priority -->
    <div class="card">
        <div class="card-title" style="color:#dc2626;"><i class="fas fa-exclamation-triangle"></i> Slow Learner Priority List</div>
        @forelse($slowLearnerList as $sl)
        <div style="display:flex;align-items:center;gap:12px;padding:12px;background:#fef2f2;border-radius:10px;margin-bottom:8px;">
            <div style="width:40px;height:40px;background:#fee2e2;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-user" style="color:#dc2626;"></i>
            </div>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:14px;">{{ $sl->student->user->name }}</div>
                <div style="font-size:12px;color:#64748b;">{{ $sl->assessment->title }}</div>
            </div>
            <span class="badge badge-danger">{{ $sl->percentage }}%</span>
        </div>
        @empty
        <p style="color:#94a3b8;font-size:14px;"><i class="fas fa-check-circle" style="color:#059669;"></i> No slow learners</p>
        @endforelse
        <a href="{{ route('teacher.slow-learners') }}" class="btn btn-danger" style="width:100%;justify-content:center;margin-top:12px;"><i class="fas fa-arrow-right"></i> View All</a>
    </div>
</div>

<div class="grid-2">
    <!-- Upcoming Classes -->
    <div class="card">
        <div class="card-title" style="color:#3b82f6;"><i class="fas fa-video"></i> Upcoming Classes</div>
        @forelse($upcomingClassList as $class)
        <div style="display:flex;align-items:center;gap:12px;padding:12px;background:#eff6ff;border-radius:10px;margin-bottom:8px;">
            <div style="width:40px;height:40px;background:#dbeafe;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-video" style="color:#3b82f6;"></i>
            </div>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:14px;">{{ $class->title }}</div>
                <div style="font-size:12px;color:#64748b;">{{ $class->student->user->name }} | {{ $class->scheduled_at->format('M d, h:i A') }}</div>
            </div>
            <a href="{{ $class->meeting_link }}" target="_blank" class="btn btn-primary btn-sm">Join</a>
        </div>
        @empty<p style="color:#94a3b8;font-size:14px;">No upcoming classes</p>@endforelse
    </div>

    <!-- Pending Submissions -->
    <div class="card">
        <div class="card-title" style="color:#d97706;"><i class="fas fa-inbox"></i> Pending Submissions</div>
        @forelse($pendingSubmissionsList as $sub)
        <div style="display:flex;align-items:center;gap:12px;padding:12px;background:#fffbeb;border-radius:10px;margin-bottom:8px;">
            <div style="width:40px;height:40px;background:#fef3c7;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-file-alt" style="color:#d97706;"></i>
            </div>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:14px;">{{ $sub->assignment->title }}</div>
                <div style="font-size:12px;color:#64748b;">{{ $sub->student->user->name }} | {{ $sub->assignment->course->title }}</div>
            </div>
            <a href="{{ route('teacher.submissions') }}" class="btn btn-warning btn-sm">Grade</a>
        </div>
        @empty<p style="color:#94a3b8;font-size:14px;">No pending submissions</p>@endforelse
    </div>
</div>
@endsection
