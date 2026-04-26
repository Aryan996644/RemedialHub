@extends('layouts.teacher')
@section('title', $course->title)
@section('page-title', $course->title)

@section('styles')
<style>
.tab-btn { padding:10px 20px;background:none;border:none;border-bottom:3px solid transparent;cursor:pointer;font-size:14px;font-weight:500;color:#64748b;transition:all 0.2s;font-family:'Inter',sans-serif; }
.tab-btn.active { border-bottom-color:#6366f1;color:#4f46e5; }
.tab-content { display:none; }
.tab-content.active { display:block; }
</style>
@endsection

@section('content')
<!-- Course Header -->
<div class="card" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;border:none;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;">
        <div>
            <h2 style="font-size:22px;font-weight:700;margin-bottom:8px;">{{ $course->title }}</h2>
            <p style="opacity:0.85;font-size:14px;max-width:600px;">{{ $course->description }}</p>
            <div style="display:flex;gap:12px;margin-top:16px;">
                <span style="background:rgba(255,255,255,0.2);padding:4px 12px;border-radius:20px;font-size:12px;"><i class="fas fa-tag"></i> {{ $course->category }}</span>
                <span style="background:rgba(255,255,255,0.2);padding:4px 12px;border-radius:20px;font-size:12px;"><i class="fas fa-layer-group"></i> {{ ucfirst($course->level) }}</span>
                <span style="background:rgba(255,255,255,0.2);padding:4px 12px;border-radius:20px;font-size:12px;"><i class="fas fa-clock"></i> {{ $course->duration }}</span>
                <span style="background:rgba(255,255,255,0.2);padding:4px 12px;border-radius:20px;font-size:12px;"><i class="fas fa-users"></i> {{ $course->enrollments_count }} enrolled</span>
            </div>
        </div>
        <span class="badge {{ $course->status === 'approved' ? 'badge-success' : 'badge-warning' }}" style="font-size:13px;">{{ ucfirst($course->status) }}</span>
    </div>
</div>

<!-- Tabs -->
<div style="background:#fff;border-radius:12px;padding:0 24px;margin-bottom:24px;border:1px solid #e2e8f0;display:flex;gap:4px;overflow-x:auto;">
    <button class="tab-btn active" onclick="showTab('overview')">Overview</button>
    <button class="tab-btn" onclick="showTab('videos')">Videos ({{ $course->videos_count }})</button>
    <button class="tab-btn" onclick="showTab('articles')">Articles ({{ $course->articles_count }})</button>
    <button class="tab-btn" onclick="showTab('assignments')">Assignments</button>
    <button class="tab-btn" onclick="showTab('classes')">Remedial Classes</button>
    <button class="tab-btn" onclick="showTab('students')">Enrolled Students</button>
</div>

<!-- Overview Tab -->
<div id="tab-overview" class="tab-content active">
    <div class="grid-3">
        <div class="stat-card" style="text-align:center;">
            <i class="fas fa-play-circle" style="font-size:32px;color:#6366f1;margin-bottom:8px;"></i>
            <div style="font-size:24px;font-weight:700;">{{ $course->videos_count }}</div>
            <div style="color:#64748b;font-size:13px;">Video Lessons</div>
        </div>
        <div class="stat-card" style="text-align:center;">
            <i class="fas fa-file-alt" style="font-size:32px;color:#059669;margin-bottom:8px;"></i>
            <div style="font-size:24px;font-weight:700;">{{ $course->articles_count }}</div>
            <div style="color:#64748b;font-size:13px;">Articles</div>
        </div>
        <div class="stat-card" style="text-align:center;">
            <i class="fas fa-users" style="font-size:32px;color:#3b82f6;margin-bottom:8px;"></i>
            <div style="font-size:24px;font-weight:700;">{{ $course->enrollments_count }}</div>
            <div style="color:#64748b;font-size:13px;">Students Enrolled</div>
        </div>
    </div>
</div>

<!-- Videos Tab -->
<div id="tab-videos" class="tab-content">
    <div class="card">
        <div class="card-title"><i class="fas fa-play-circle" style="color:#6366f1;"></i> Video Lessons</div>
        <div class="table-container">
            <table>
                <thead><tr><th>#</th><th>Title</th><th>Duration</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($course->videos as $video)
                    <tr><td>{{ $video->order_no }}</td><td>{{ $video->title }}</td><td>{{ $video->duration }}</td>
                    <td><span class="badge badge-success">{{ ucfirst($video->status) }}</span></td></tr>
                    @empty<tr><td colspan="4" style="text-align:center;color:#94a3b8;">No videos yet</td></tr>@endforelse
                </tbody>
            </table>
        </div>
        <a href="{{ route('teacher.videos') }}" class="btn btn-primary" style="margin-top:12px;"><i class="fas fa-plus"></i> Add Video</a>
    </div>
</div>

<!-- Articles Tab -->
<div id="tab-articles" class="tab-content">
    <div class="card">
        <div class="card-title"><i class="fas fa-file-alt" style="color:#059669;"></i> Articles / Notes</div>
        <div class="table-container">
            <table>
                <thead><tr><th>#</th><th>Title</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($course->articles as $article)
                    <tr><td>{{ $article->order_no }}</td><td>{{ $article->title }}</td>
                    <td><span class="badge badge-success">{{ ucfirst($article->status) }}</span></td></tr>
                    @empty<tr><td colspan="3" style="text-align:center;color:#94a3b8;">No articles yet</td></tr>@endforelse
                </tbody>
            </table>
        </div>
        <a href="{{ route('teacher.articles') }}" class="btn btn-primary" style="margin-top:12px;"><i class="fas fa-plus"></i> Add Article</a>
    </div>
</div>

<!-- Assignments Tab -->
<div id="tab-assignments" class="tab-content">
    <div class="card">
        <div class="card-title"><i class="fas fa-tasks" style="color:#d97706;"></i> Assignments</div>
        @forelse($course->assignments as $a)
        <div style="padding:12px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:8px;display:flex;justify-content:space-between;align-items:center;">
            <div><div style="font-weight:600;">{{ $a->title }}</div><div style="font-size:12px;color:#64748b;">{{ $a->student->user->name }} | Due: {{ $a->due_date->format('M d, Y') }}</div></div>
            <span class="badge {{ $a->status === 'graded' ? 'badge-success' : ($a->status === 'submitted' ? 'badge-info' : 'badge-warning') }}">{{ ucfirst($a->status) }}</span>
        </div>
        @empty<p style="color:#94a3b8;">No assignments for this course</p>@endforelse
    </div>
</div>

<!-- Classes Tab -->
<div id="tab-classes" class="tab-content">
    <div class="card">
        <div class="card-title"><i class="fas fa-video" style="color:#3b82f6;"></i> Remedial Classes</div>
        @forelse($course->remedialClasses as $rc)
        <div style="padding:12px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:8px;display:flex;justify-content:space-between;align-items:center;">
            <div><div style="font-weight:600;">{{ $rc->title }}</div><div style="font-size:12px;color:#64748b;">{{ $rc->student->user->name }} | {{ $rc->scheduled_at->format('M d, h:i A') }}</div></div>
            <span class="badge badge-info">{{ $rc->status }}</span>
        </div>
        @empty<p style="color:#94a3b8;">No remedial classes scheduled</p>@endforelse
    </div>
</div>

<!-- Students Tab -->
<div id="tab-students" class="tab-content">
    <div class="card">
        <div class="card-title"><i class="fas fa-users" style="color:#6366f1;"></i> Enrolled Students</div>
        <div class="table-container">
            <table>
                <thead><tr><th>Student</th><th>Enrolled At</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($course->enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->student->user->name }}</td>
                        <td>{{ $enrollment->enrolled_at ? \Carbon\Carbon::parse($enrollment->enrolled_at)->format('M d, Y') : '-' }}</td>
                        <td><span class="badge badge-success">{{ ucfirst($enrollment->status) }}</span></td>
                    </tr>
                    @empty<tr><td colspan="3" style="text-align:center;color:#94a3b8;">No students enrolled</td></tr>@endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function showTab(name) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    event.target.classList.add('active');
}
</script>
@endsection
