@extends('layouts.student')
@section('title', 'All Courses')
@section('page-title', 'All Courses')

@section('styles')
<style>
.course-card {
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    border:1px solid #e2e8f0;
    box-shadow:0 2px 8px rgba(0,0,0,0.06);
    transition:all 0.3s ease;
    display:flex;
    flex-direction:column;
}
.course-card:hover {
    box-shadow:0 12px 32px rgba(79,70,229,0.13);
    transform:translateY(-4px);
    border-color:#c7d2fe;
}
.filter-bar {
    background:#fff;
    border-radius:16px;
    padding:20px 24px;
    border:1px solid #e2e8f0;
    margin-bottom:24px;
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    align-items:center;
}
.filter-input {
    flex:1;
    min-width:200px;
    padding:10px 16px;
    border:1.5px solid #e2e8f0;
    border-radius:10px;
    font-size:14px;
    font-family:'Inter',sans-serif;
    outline:none;
    transition:all 0.2s;
    background:#f8fafc;
}
.filter-input:focus { border-color:#6366f1; background:#fff; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
.filter-select {
    padding:10px 14px;
    border:1.5px solid #e2e8f0;
    border-radius:10px;
    font-size:14px;
    font-family:'Inter',sans-serif;
    outline:none;
    background:#f8fafc;
    cursor:pointer;
    transition:all 0.2s;
}
.filter-select:focus { border-color:#6366f1; }
.level-badge {
    display:inline-block;
    padding:3px 10px;
    border-radius:9999px;
    font-size:11px;
    font-weight:600;
    letter-spacing:0.5px;
    text-transform:uppercase;
}
.level-beginner { background:#dcfce7; color:#166534; }
.level-intermediate { background:#fef3c7; color:#92400e; }
.level-advanced { background:#ede9fe; color:#5b21b6; }
.enrolled-ribbon {
    position:absolute;
    top:12px;
    right:12px;
    background:#059669;
    color:#fff;
    font-size:11px;
    font-weight:700;
    padding:4px 10px;
    border-radius:9999px;
    display:flex;
    align-items:center;
    gap:4px;
}
.recommended-ribbon {
    position:absolute;
    top:12px;
    right:12px;
    background:#7c3aed;
    color:#fff;
    font-size:11px;
    font-weight:700;
    padding:4px 10px;
    border-radius:9999px;
    display:flex;
    align-items:center;
    gap:4px;
}
.stats-row { display:flex; gap:16px; flex-wrap:wrap; margin-bottom:16px; }
.stat-pill { font-size:12px; color:#64748b; display:flex; align-items:center; gap:5px; }
</style>
@endsection

@section('content')
{{-- ── Page Header ── --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:26px;font-weight:800;color:#1e293b;margin-bottom:4px;">
            <i class="fas fa-book-open" style="color:#6366f1;margin-right:8px;"></i>All Courses
        </h1>
        <p style="color:#64748b;font-size:14px;">Browse and enroll in any course available on RemedialHub</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('student.recommended-courses') }}" class="btn btn-primary">
            <i class="fas fa-star"></i> My Recommendations
        </a>
    </div>
</div>

{{-- ── Filters ── --}}
<form method="GET" action="{{ route('student.courses.all') }}" class="filter-bar">
    <i class="fas fa-search" style="color:#94a3b8;font-size:15px;"></i>
    <input type="text" name="search" class="filter-input" placeholder="Search courses, categories…"
           value="{{ request('search') }}">

    <select name="level" class="filter-select">
        <option value="">All Levels</option>
        <option value="beginner"   {{ request('level') === 'beginner'      ? 'selected' : '' }}>Beginner</option>
        <option value="intermediate" {{ request('level') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
        <option value="advanced"   {{ request('level') === 'advanced'      ? 'selected' : '' }}>Advanced</option>
    </select>

    @if($categories->isNotEmpty())
    <select name="category" class="filter-select">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
    @endif

    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
    @if(request()->anyFilled(['search','level','category']))
    <a href="{{ route('student.courses.all') }}" class="btn" style="background:#f1f5f9;color:#64748b;">
        <i class="fas fa-times"></i> Clear
    </a>
    @endif
</form>

{{-- ── Stats Bar ── --}}
<div style="background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:16px;padding:20px 28px;margin-bottom:28px;display:flex;gap:32px;flex-wrap:wrap;">
    <div style="color:#fff;">
        <div style="font-size:28px;font-weight:800;">{{ $courses->count() }}</div>
        <div style="font-size:13px;opacity:0.8;">Available Courses</div>
    </div>
    <div style="color:#fff;">
        <div style="font-size:28px;font-weight:800;">{{ count($enrolledCourseIds) }}</div>
        <div style="font-size:13px;opacity:0.8;">Enrolled</div>
    </div>
    <div style="color:#fff;">
        <div style="font-size:28px;font-weight:800;">{{ count($recommendedCourseIds) }}</div>
        <div style="font-size:13px;opacity:0.8;">Recommended for You</div>
    </div>
    <div style="color:#fff;">
        <div style="font-size:28px;font-weight:800;">{{ $courses->where('level','beginner')->count() }}</div>
        <div style="font-size:13px;opacity:0.8;">Beginner Courses</div>
    </div>
</div>

{{-- ── Course Grid ── --}}
@if($courses->isEmpty())
<div style="text-align:center;padding:80px;background:#fff;border-radius:20px;border:1px solid #e2e8f0;">
    <div style="width:80px;height:80px;background:#ede9fe;border-radius:20px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:20px;">
        <i class="fas fa-book" style="color:#6366f1;font-size:36px;"></i>
    </div>
    <h3 style="font-size:22px;font-weight:700;color:#1e293b;margin-bottom:8px;">No Courses Found</h3>
    <p style="color:#64748b;margin-bottom:24px;">
        @if(request()->anyFilled(['search','level','category']))
            Try different search criteria or clear your filters.
        @else
            No approved courses are available yet. Check back soon!
        @endif
    </p>
    @if(request()->anyFilled(['search','level','category']))
    <a href="{{ route('student.courses.all') }}" class="btn btn-primary">
        <i class="fas fa-times"></i> Clear Filters
    </a>
    @endif
</div>
@else
<div class="grid-3">
    @foreach($courses as $course)
    @php
        $isEnrolled    = in_array($course->id, $enrolledCourseIds);
        $isRecommended = in_array($course->id, $recommendedCourseIds);
        $bannerGradient = match($course->level) {
            'beginner'     => 'linear-gradient(135deg,#059669,#10b981)',
            'intermediate' => 'linear-gradient(135deg,#d97706,#f59e0b)',
            default        => 'linear-gradient(135deg,#6366f1,#8b5cf6)',
        };
    @endphp
    <div class="course-card">
        {{-- Banner --}}
        <div style="padding:22px 24px;background:{{ $bannerGradient }};color:#fff;position:relative;">
            @if($isEnrolled)
                <div class="enrolled-ribbon" style="top:12px;right:12px;position:absolute;">
                    <i class="fas fa-check-circle"></i> Enrolled
                </div>
            @elseif($isRecommended)
                <div class="recommended-ribbon" style="top:12px;right:12px;position:absolute;">
                    <i class="fas fa-star"></i> Recommended
                </div>
            @endif
            <span class="level-badge level-{{ $course->level }}" style="margin-bottom:8px;display:inline-block;background:rgba(255,255,255,0.2);color:#fff;">
                {{ ucfirst($course->level) }}
            </span>
            <div style="font-size:17px;font-weight:700;line-height:1.35;padding-right:{{ ($isEnrolled || $isRecommended) ? '80px' : '0' }};">
                {{ $course->title }}
            </div>
            <div style="font-size:12px;opacity:0.85;margin-top:6px;">{{ $course->category }}</div>
        </div>

        {{-- Body --}}
        <div style="padding:20px 24px;flex:1;display:flex;flex-direction:column;">
            <p style="font-size:13px;color:#64748b;line-height:1.6;margin-bottom:16px;flex:1;">
                {{ Str::limit($course->description, 110) }}
            </p>

            {{-- Stats --}}
            <div class="stats-row">
                <span class="stat-pill"><i class="fas fa-play-circle" style="color:#6366f1;"></i> {{ $course->videos_count }} Videos</span>
                <span class="stat-pill"><i class="fas fa-file-alt" style="color:#059669;"></i> {{ $course->articles_count }} Articles</span>
                <span class="stat-pill"><i class="fas fa-users" style="color:#d97706;"></i> {{ $course->enrollments_count }} Enrolled</span>
                @if($course->duration)
                <span class="stat-pill"><i class="fas fa-clock" style="color:#6366f1;"></i> {{ $course->duration }}</span>
                @endif
            </div>

            {{-- Teacher --}}
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:16px;">
                <div style="width:30px;height:30px;background:#ede9fe;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-chalkboard-teacher" style="color:#6366f1;font-size:12px;"></i>
                </div>
                <span style="font-size:13px;color:#475569;font-weight:500;">{{ $course->teacher->user->name }}</span>
            </div>

            {{-- Actions --}}
            <div style="display:flex;gap:8px;">
                <a href="{{ route('student.courses.show', $course->id) }}"
                   class="btn" style="flex:1;justify-content:center;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;">
                    <i class="fas fa-eye"></i> View
                </a>

                @if($isEnrolled)
                <button disabled class="btn btn-success" style="flex:1;justify-content:center;opacity:0.7;cursor:default;">
                    <i class="fas fa-check"></i> Enrolled
                </button>
                @else
                <form action="{{ route('student.enroll') }}" method="POST" style="flex:1;">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button type="submit" class="btn btn-primary"
                            style="width:100%;justify-content:center;"
                            onclick="return confirm('Enroll in {{ addslashes($course->title) }}?')">
                        <i class="fas fa-graduation-cap"></i> Enroll
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
