@extends('layouts.admin')
@section('title', 'Admin Dashboard - RemedialHub')
@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Stats Cards -->
<div class="grid-4">
    <div class="stat-card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="font-size:13px; color:#64748b; font-weight:500;">Total Students</div>
                <div style="font-size:28px; font-weight:700; color:#1e293b; margin-top:4px;">{{ $totalStudents }}</div>
            </div>
            <div style="width:48px;height:48px;background:#dbeafe;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-user-graduate" style="color:#3b82f6;font-size:20px;"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="font-size:13px; color:#64748b; font-weight:500;">Total Teachers</div>
                <div style="font-size:28px; font-weight:700; color:#1e293b; margin-top:4px;">{{ $totalTeachers }}</div>
            </div>
            <div style="width:48px;height:48px;background:#ede9fe;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-chalkboard-teacher" style="color:#8b5cf6;font-size:20px;"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="font-size:13px; color:#64748b; font-weight:500;">Total Courses</div>
                <div style="font-size:28px; font-weight:700; color:#1e293b; margin-top:4px;">{{ $totalCourses }}</div>
            </div>
            <div style="width:48px;height:48px;background:#dcfce7;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-book-open" style="color:#059669;font-size:20px;"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="font-size:13px; color:#64748b; font-weight:500;">Total Tests</div>
                <div style="font-size:28px; font-weight:700; color:#1e293b; margin-top:4px;">{{ $totalTests }}</div>
            </div>
            <div style="width:48px;height:48px;background:#fef3c7;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-clipboard-check" style="color:#d97706;font-size:20px;"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="font-size:13px; color:#64748b; font-weight:500;">Slow Learners</div>
                <div style="font-size:28px; font-weight:700; color:#dc2626; margin-top:4px;">{{ $slowLearners }}</div>
            </div>
            <div style="width:48px;height:48px;background:#fee2e2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-exclamation-triangle" style="color:#dc2626;font-size:20px;"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="font-size:13px; color:#64748b; font-weight:500;">Upcoming Classes</div>
                <div style="font-size:28px; font-weight:700; color:#1e293b; margin-top:4px;">{{ $upcomingClasses }}</div>
            </div>
            <div style="width:48px;height:48px;background:#dbeafe;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-video" style="color:#3b82f6;font-size:20px;"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="font-size:13px; color:#64748b; font-weight:500;">Pending Assignments</div>
                <div style="font-size:28px; font-weight:700; color:#1e293b; margin-top:4px;">{{ $pendingAssignments }}</div>
            </div>
            <div style="width:48px;height:48px;background:#fef3c7;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-tasks" style="color:#d97706;font-size:20px;"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="font-size:13px; color:#64748b; font-weight:500;">Avg Progress</div>
                <div style="font-size:28px; font-weight:700; color:#059669; margin-top:4px;">{{ number_format($avgProgress, 1) }}%</div>
            </div>
            <div style="width:48px;height:48px;background:#dcfce7;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-chart-line" style="color:#059669;font-size:20px;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Students + Recent Results -->
<div class="grid-2">
    <div class="card">
        <div class="card-title"><i class="fas fa-user-graduate" style="color:#6366f1;"></i> Recent Students</div>
        <div class="table-container">
            <table>
                <thead><tr><th>Name</th><th>Roll No</th><th>Dept</th><th>Semester</th></tr></thead>
                <tbody>
                    @forelse($recentStudents as $s)
                    <tr><td>{{ $s->user->name }}</td><td>{{ $s->roll_no }}</td><td>{{ $s->department }}</td><td>{{ $s->semester }}</td></tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:#94a3b8;">No students yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-title"><i class="fas fa-poll" style="color:#8b5cf6;"></i> Recent Test Results</div>
        <div class="table-container">
            <table>
                <thead><tr><th>Student</th><th>Test</th><th>Score</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($recentResults as $r)
                    <tr>
                        <td>{{ $r->student->user->name }}</td>
                        <td>{{ $r->assessment->title }}</td>
                        <td>{{ $r->percentage }}%</td>
                        <td>
                            @if($r->status === 'slow_learner')<span class="badge badge-danger">Slow Learner</span>
                            @elseif($r->status === 'intermediate')<span class="badge badge-warning">Intermediate</span>
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
</div>

<!-- Slow Learner Alerts + Upcoming Classes -->
<div class="grid-2">
    <div class="card">
        <div class="card-title" style="color:#dc2626;"><i class="fas fa-exclamation-triangle"></i> Slow Learner Alerts</div>
        @forelse($slowLearnerAlerts as $alert)
        <div style="display:flex;align-items:center;gap:12px;padding:12px;background:#fef2f2;border-radius:10px;margin-bottom:8px;">
            <div style="width:40px;height:40px;background:#fee2e2;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-user" style="color:#dc2626;"></i>
            </div>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:14px;color:#1e293b;">{{ $alert->student->user->name }}</div>
                <div style="font-size:12px;color:#64748b;">{{ $alert->assessment->title }} - Score: {{ $alert->percentage }}%</div>
            </div>
            <span class="badge badge-danger">{{ $alert->percentage }}%</span>
        </div>
        @empty
        <p style="color:#94a3b8;font-size:14px;">No slow learner alerts</p>
        @endforelse
    </div>

    <div class="card">
        <div class="card-title" style="color:#3b82f6;"><i class="fas fa-video"></i> Upcoming Remedial Classes</div>
        @forelse($upcomingRemedialClasses as $class)
        <div style="display:flex;align-items:center;gap:12px;padding:12px;background:#eff6ff;border-radius:10px;margin-bottom:8px;">
            <div style="width:40px;height:40px;background:#dbeafe;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-video" style="color:#3b82f6;"></i>
            </div>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:14px;color:#1e293b;">{{ $class->title }}</div>
                <div style="font-size:12px;color:#64748b;">{{ $class->teacher->user->name }} | {{ $class->scheduled_at->format('M d, h:i A') }}</div>
            </div>
            <span class="badge badge-info">{{ $class->platform }}</span>
        </div>
        @empty
        <p style="color:#94a3b8;font-size:14px;">No upcoming classes</p>
        @endforelse
    </div>
</div>

<!-- Course Approval Requests -->
@if($pendingCourses->count() > 0)
<div class="card">
    <div class="card-title" style="color:#d97706;"><i class="fas fa-clock"></i> Course Approval Requests</div>
    <div class="table-container">
        <table>
            <thead><tr><th>Course</th><th>Teacher</th><th>Category</th><th>Level</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($pendingCourses as $course)
                <tr>
                    <td style="font-weight:600;">{{ $course->title }}</td>
                    <td>{{ $course->teacher->user->name }}</td>
                    <td>{{ $course->category }}</td>
                    <td><span class="badge badge-purple">{{ ucfirst($course->level) }}</span></td>
                    <td style="display:flex;gap:6px;">
                        <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST">@csrf @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Approve</button>
                        </form>
                        <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST">@csrf @method('PATCH')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Reject</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
