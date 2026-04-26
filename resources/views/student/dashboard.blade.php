@extends('layouts.student')
@section('title', 'Student Dashboard')
@section('page-title', 'My Dashboard')

@section('content')
<!-- Welcome Banner -->
<div style="background:linear-gradient(135deg,#4f46e5,#7c3aed,#a21caf);border-radius:20px;padding:28px 32px;margin-bottom:24px;color:#fff;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-20px;right:-20px;width:150px;height:150px;background:rgba(255,255,255,0.05);border-radius:50%;"></div>
    <div style="position:absolute;bottom:-40px;right:60px;width:200px;height:200px;background:rgba(255,255,255,0.05);border-radius:50%;"></div>
    <div style="position:relative;z-index:1;">
        <h2 style="font-size:24px;font-weight:700;margin-bottom:6px;">Welcome back, {{ auth()->user()->name }}! 👋</h2>
        <p style="opacity:0.85;font-size:15px;">
            @if($hasAssessment && $latestResult)
                Your skill level is <strong>{{ ucfirst($latestResult->skill_level) }}</strong> with a score of <strong>{{ $latestResult->percentage }}%</strong>.
                @if($latestResult->status === 'slow_learner')
                    Don't worry — remedial courses are recommended to help you improve!
                @else
                    Great performance! Keep growing.
                @endif
            @else
                You haven't taken a skill assessment yet. Take one to unlock personalized courses!
            @endif
        </p>
        @if(!$hasAssessment)
        <a href="{{ route('student.assessment.start') }}" style="display:inline-block;margin-top:16px;background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3);color:#fff;padding:10px 24px;border-radius:10px;text-decoration:none;font-weight:600;font-size:14px;">
            <i class="fas fa-play-circle"></i> Take Assessment Now
        </a>
        @endif
    </div>
</div>

<!-- Status Badges -->
@if($hasAssessment && $latestResult)
<div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:24px;">
    <div style="background:#fff;border-radius:12px;padding:16px 24px;border:1px solid #e2e8f0;display:flex;align-items:center;gap:12px;flex:1;min-width:200px;">
        <div style="width:44px;height:44px;background:{{ $latestResult->status === 'slow_learner' ? '#fee2e2' : ($latestResult->status === 'intermediate' ? '#fef3c7' : '#dcfce7') }};border-radius:12px;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-chart-bar" style="color:{{ $latestResult->status === 'slow_learner' ? '#dc2626' : ($latestResult->status === 'intermediate' ? '#d97706' : '#059669') }};font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:12px;color:#64748b;">Skill Level</div>
            <div style="font-weight:700;color:#1e293b;">{{ ucfirst($latestResult->skill_level) }}</div>
        </div>
    </div>
    <div style="background:#fff;border-radius:12px;padding:16px 24px;border:1px solid #e2e8f0;display:flex;align-items:center;gap:12px;flex:1;min-width:200px;">
        <div style="width:44px;height:44px;background:#ede9fe;border-radius:12px;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-star" style="color:#7c3aed;font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:12px;color:#64748b;">Recommended Courses</div>
            <div style="font-weight:700;color:#1e293b;">{{ $recommendedCourses }}</div>
        </div>
    </div>
    <div style="background:#fff;border-radius:12px;padding:16px 24px;border:1px solid #e2e8f0;display:flex;align-items:center;gap:12px;flex:1;min-width:200px;">
        <div style="width:44px;height:44px;background:#fef3c7;border-radius:12px;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-tasks" style="color:#d97706;font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:12px;color:#64748b;">Pending Assignments</div>
            <div style="font-weight:700;color:#1e293b;">{{ $assignmentsDue }}</div>
        </div>
    </div>
    <div style="background:#fff;border-radius:12px;padding:16px 24px;border:1px solid #e2e8f0;display:flex;align-items:center;gap:12px;flex:1;min-width:200px;">
        <div style="width:44px;height:44px;background:#dcfce7;border-radius:12px;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-video" style="color:#059669;font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:12px;color:#64748b;">Attendance</div>
            <div style="font-weight:700;color:#1e293b;">{{ $attendancePercent }}%</div>
        </div>
    </div>
</div>
@endif

<div class="grid-2">
    <!-- Quick Actions -->
    <div class="card">
        <div class="card-title"><i class="fas fa-bolt" style="color:#6366f1;"></i> Quick Actions</div>
        <div style="display:grid;gap:12px;">
            <a href="{{ route('student.assessment.start') }}" style="display:flex;align-items:center;gap:14px;padding:16px;background:linear-gradient(135deg,#ede9fe,#e0e7ff);border-radius:12px;text-decoration:none;transition:all 0.2s;border:1px solid #c7d2fe;">
                <div style="width:44px;height:44px;background:#6366f1;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-clipboard-check" style="color:#fff;font-size:18px;"></i></div>
                <div><div style="font-weight:600;color:#3730a3;">Skill Assessment</div><div style="font-size:12px;color:#6366f1;">Test your knowledge</div></div>
            </a>
            <a href="{{ route('student.courses.all') }}" style="display:flex;align-items:center;gap:14px;padding:16px;background:linear-gradient(135deg,#fdf4ff,#f3e8ff);border-radius:12px;text-decoration:none;border:1px solid #e9d5ff;">
                <div style="width:44px;height:44px;background:#7c3aed;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-book-open" style="color:#fff;font-size:18px;"></i></div>
                <div><div style="font-weight:600;color:#581c87;">Browse All Courses</div><div style="font-size:12px;color:#7c3aed;">Explore & enroll freely</div></div>
            </a>
            <a href="{{ route('student.recommended-courses') }}" style="display:flex;align-items:center;gap:14px;padding:16px;background:linear-gradient(135deg,#dcfce7,#d1fae5);border-radius:12px;text-decoration:none;border:1px solid #a7f3d0;">
                <div style="width:44px;height:44px;background:#059669;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-star" style="color:#fff;font-size:18px;"></i></div>
                <div><div style="font-weight:600;color:#065f46;">Recommended Courses</div><div style="font-size:12px;color:#059669;">Personalized for you</div></div>
            </a>
            <a href="{{ route('student.remedial-classes') }}" style="display:flex;align-items:center;gap:14px;padding:16px;background:linear-gradient(135deg,#dbeafe,#e0f2fe);border-radius:12px;text-decoration:none;border:1px solid #bfdbfe;">
                <div style="width:44px;height:44px;background:#3b82f6;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-video" style="color:#fff;font-size:18px;"></i></div>
                <div><div style="font-weight:600;color:#1e3a8a;">Remedial Classes</div><div style="font-size:12px;color:#3b82f6;">Live sessions with teachers</div></div>
            </a>
            <a href="{{ route('student.assignments') }}" style="display:flex;align-items:center;gap:14px;padding:16px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:12px;text-decoration:none;border:1px solid #fcd34d;">
                <div style="width:44px;height:44px;background:#d97706;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-tasks" style="color:#fff;font-size:18px;"></i></div>
                <div><div style="font-weight:600;color:#92400e;">Assignments</div><div style="font-size:12px;color:#d97706;">Submit your work</div></div>
            </a>
        </div>
    </div>

    <!-- Next Class + Progress -->
    <div style="display:flex;flex-direction:column;gap:20px;">
        <!-- Upcoming Class -->
        @if($upcomingClass)
        <div class="card" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1px solid #bfdbfe;">
            <div class="card-title" style="color:#1e40af;"><i class="fas fa-video"></i> Next Remedial Class</div>
            <div style="font-size:18px;font-weight:700;color:#1e293b;margin-bottom:8px;">{{ $upcomingClass->title }}</div>
            <div style="font-size:14px;color:#64748b;margin-bottom:4px;"><i class="fas fa-chalkboard-teacher" style="color:#3b82f6;"></i> {{ $upcomingClass->teacher->user->name }}</div>
            <div style="font-size:14px;color:#64748b;margin-bottom:4px;"><i class="fas fa-calendar" style="color:#3b82f6;"></i> {{ \Carbon\Carbon::parse($upcomingClass->scheduled_at)->format('M d, Y - h:i A') }}</div>
            <div style="font-size:14px;color:#64748b;margin-bottom:16px;"><i class="fas fa-clock" style="color:#3b82f6;"></i> {{ $upcomingClass->duration }} minutes | {{ $upcomingClass->platform }}</div>
            <a href="{{ $upcomingClass->meeting_link }}" target="_blank" class="btn btn-primary" style="width:100%;justify-content:center;"><i class="fas fa-video"></i> Join Class</a>
        </div>
        @endif

        <!-- My Progress -->
        <div class="card">
            <div class="card-title"><i class="fas fa-chart-line" style="color:#059669;"></i> My Progress</div>
            @if($progressReport)
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                    <span style="font-size:13px;color:#64748b;">Initial: {{ $progressReport->initial_score }}%</span>
                    <span style="font-size:13px;font-weight:600;color:{{ $progressReport->status === 'Improved' ? '#059669' : '#dc2626' }};">Current: {{ $progressReport->current_score }}%</span>
                </div>
                <div style="background:#e2e8f0;border-radius:9999px;height:12px;overflow:hidden;margin-bottom:8px;">
                    <div style="width:{{ min($progressReport->current_score, 100) }}%;height:100%;background:linear-gradient(90deg,#6366f1,#059669);border-radius:9999px;transition:width 1s;"></div>
                </div>
                <div style="text-align:center;font-size:14px;font-weight:600;color:{{ $progressReport->status === 'Improved' ? '#059669' : '#dc2626' }};">
                    {{ $progressReport->status }} — {{ $progressReport->progress_percentage > 0 ? '+' : '' }}{{ $progressReport->progress_percentage }}%
                </div>
            </div>
            @else
            <p style="color:#94a3b8;font-size:14px;text-align:center;padding:16px;">No progress report yet</p>
            @endif
            <a href="{{ route('student.progress') }}" class="btn btn-success" style="width:100%;justify-content:center;margin-top:12px;"><i class="fas fa-chart-bar"></i> View Full Report</a>
        </div>
    </div>
</div>

{{-- ── All Courses Section ── --}}
@php
    $allCourses = \App\Models\Course::with('teacher.user')
        ->withCount(['videos','articles','enrollments'])
        ->where('status','approved')
        ->latest()->take(6)->get();
    $myEnrolledIds = \App\Models\CourseEnrollment::where('student_id', $student->id)->pluck('course_id')->toArray();
    $myRecommendedIds = \App\Models\CourseRecommendation::where('student_id', $student->id)->pluck('course_id')->toArray();
@endphp

<div style="margin-top:8px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
        <div>
            <h3 style="font-size:18px;font-weight:700;color:#1e293b;margin-bottom:2px;">
                <i class="fas fa-book-open" style="color:#7c3aed;margin-right:8px;"></i>All Available Courses
            </h3>
            <p style="font-size:13px;color:#64748b;">Browse all approved courses and enroll directly</p>
        </div>
        <a href="{{ route('student.courses.all') }}" class="btn btn-primary" style="white-space:nowrap;">
            <i class="fas fa-th-large"></i> View All
        </a>
    </div>

    @if($allCourses->isEmpty())
    <div style="text-align:center;padding:40px;background:#fff;border-radius:16px;border:1px solid #e2e8f0;color:#94a3b8;">
        <i class="fas fa-book" style="font-size:32px;margin-bottom:12px;display:block;"></i>
        No courses available yet. Check back soon!
    </div>
    @else
    <div class="grid-3">
        @foreach($allCourses as $course)
        @php
            $enrolled    = in_array($course->id, $myEnrolledIds);
            $recommended = in_array($course->id, $myRecommendedIds);
            $gradient = match($course->level) {
                'beginner'     => 'linear-gradient(135deg,#059669,#10b981)',
                'intermediate' => 'linear-gradient(135deg,#d97706,#f59e0b)',
                default        => 'linear-gradient(135deg,#6366f1,#8b5cf6)',
            };
        @endphp
        <div style="background:#fff;border-radius:18px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,0.05);transition:all 0.3s;display:flex;flex-direction:column;"
             onmouseover="this.style.boxShadow='0 10px 28px rgba(99,102,241,0.13)';this.style.transform='translateY(-3px)'"
             onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)';this.style.transform='none'">
            {{-- Banner --}}
            <div style="padding:18px 20px;background:{{ $gradient }};color:#fff;position:relative;">
                @if($enrolled)
                <span style="position:absolute;top:10px;right:10px;background:rgba(255,255,255,0.25);color:#fff;font-size:10px;font-weight:700;padding:3px 8px;border-radius:9999px;">
                    <i class="fas fa-check"></i> Enrolled
                </span>
                @elseif($recommended)
                <span style="position:absolute;top:10px;right:10px;background:rgba(255,255,255,0.25);color:#fff;font-size:10px;font-weight:700;padding:3px 8px;border-radius:9999px;">
                    <i class="fas fa-star"></i> For You
                </span>
                @endif
                <div style="font-size:10px;opacity:0.8;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">{{ ucfirst($course->level) }}</div>
                <div style="font-size:15px;font-weight:700;line-height:1.3;padding-right:{{ ($enrolled||$recommended)?'60px':'0' }};">{{ Str::limit($course->title, 50) }}</div>
                <div style="font-size:11px;opacity:0.8;margin-top:4px;">{{ $course->category }}</div>
            </div>

            {{-- Body --}}
            <div style="padding:16px 20px;flex:1;display:flex;flex-direction:column;">
                <div style="display:flex;gap:12px;margin-bottom:12px;flex-wrap:wrap;">
                    <span style="font-size:11px;color:#64748b;"><i class="fas fa-play-circle" style="color:#6366f1;"></i> {{ $course->videos_count }} videos</span>
                    <span style="font-size:11px;color:#64748b;"><i class="fas fa-file-alt" style="color:#059669;"></i> {{ $course->articles_count }} articles</span>
                    <span style="font-size:11px;color:#64748b;"><i class="fas fa-users" style="color:#d97706;"></i> {{ $course->enrollments_count }}</span>
                </div>
                <div style="font-size:12px;color:#94a3b8;margin-bottom:14px;flex:1;">
                    <i class="fas fa-chalkboard-teacher" style="margin-right:4px;"></i>{{ $course->teacher->user->name }}
                </div>
                <div style="display:flex;gap:6px;">
                    <a href="{{ route('student.courses.show', $course->id) }}"
                       style="flex:1;text-align:center;padding:8px;background:#f1f5f9;color:#475569;border-radius:8px;text-decoration:none;font-size:12px;font-weight:500;border:1px solid #e2e8f0;">
                        <i class="fas fa-eye"></i> View
                    </a>
                    @if($enrolled)
                    <button disabled style="flex:1;padding:8px;background:#dcfce7;color:#059669;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:default;">
                        <i class="fas fa-check"></i> Enrolled
                    </button>
                    @else
                    <form action="{{ route('student.enroll') }}" method="POST" style="flex:1;">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <button type="submit" style="width:100%;padding:8px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                            <i class="fas fa-graduation-cap"></i> Enroll
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div style="text-align:center;margin-top:8px;">
        <a href="{{ route('student.courses.all') }}" class="btn" style="background:#f1f5f9;color:#6366f1;border:1px solid #e2e8f0;font-weight:600;">
            <i class="fas fa-arrow-right"></i> See All Courses
        </a>
    </div>
    @endif
</div>
@endsection
