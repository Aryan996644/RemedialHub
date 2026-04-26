@extends('layouts.teacher')
@section('title', 'Progress Reports')
@section('page-title', 'Student Progress Reports')

@section('content')
<div class="grid-2">
    <!-- Add Progress Report -->
    <div class="card">
        <div class="card-title"><i class="fas fa-plus-circle" style="color:#059669;"></i> Add Progress Report</div>
        <form method="POST" action="{{ route('teacher.progress.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Select Student</label>
                <select name="student_id" class="form-input" required>
                    <option value="">-- Select Student --</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}">{{ $s->user->name }} ({{ $s->roll_no }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Select Course</label>
                <select name="course_id" class="form-input" required>
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}">{{ $c->title }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div class="form-group">
                    <label class="form-label">Initial Score (%)</label>
                    <input type="number" name="initial_score" class="form-input" required min="0" max="100" step="0.01" placeholder="e.g., 35">
                </div>
                <div class="form-group">
                    <label class="form-label">Current Score (%)</label>
                    <input type="number" name="current_score" class="form-input" required min="0" max="100" step="0.01" placeholder="e.g., 65">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-input" rows="3" placeholder="Observations about the student's progress..."></textarea>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Report</button>
        </form>
    </div>

    <!-- Reports List -->
    <div style="display:flex;flex-direction:column;gap:16px;">
        @forelse($reports as $report)
        <div class="stat-card" style="border-left:4px solid {{ $report->status === 'Improved' ? '#059669' : ($report->status === 'Declined' ? '#dc2626' : '#d97706') }};">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                <div>
                    <div style="font-weight:700;color:#1e293b;">{{ $report->student->user->name }}</div>
                    <div style="font-size:13px;color:#6366f1;">{{ $report->course->title }}</div>
                </div>
                <span class="badge {{ $report->status === 'Improved' ? 'badge-success' : ($report->status === 'Declined' ? 'badge-danger' : 'badge-warning') }}">
                    {{ $report->status }}
                </span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:13px;color:#64748b;margin-bottom:8px;">
                <span>Initial: <strong>{{ $report->initial_score }}%</strong></span>
                <span>Current: <strong style="color:{{ $report->status === 'Improved' ? '#059669' : '#dc2626' }}">{{ $report->current_score }}%</strong></span>
                <span>Progress: <strong>{{ $report->progress_percentage > 0 ? '+' : '' }}{{ $report->progress_percentage }}%</strong></span>
            </div>
            <div style="background:#e2e8f0;border-radius:9999px;height:8px;overflow:hidden;">
                <div style="width:{{ min($report->current_score, 100) }}%;height:100%;background:{{ $report->status === 'Improved' ? '#059669' : ($report->status === 'Declined' ? '#dc2626' : '#d97706') }};border-radius:9999px;transition:width 0.8s;"></div>
            </div>
            @if($report->remarks)
            <p style="margin-top:8px;font-size:12px;color:#64748b;font-style:italic;">{{ $report->remarks }}</p>
            @endif

            <!-- Update form -->
            <form method="POST" action="{{ route('teacher.progress.update', $report->id) }}" style="margin-top:12px;display:flex;gap:8px;">
                @csrf @method('PUT')
                <input type="number" name="current_score" class="form-input" min="0" max="100" step="0.01" value="{{ $report->current_score }}" placeholder="New score" style="flex:1;">
                <input type="text" name="remarks" class="form-input" value="{{ $report->remarks }}" placeholder="Update remarks" style="flex:2;">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-sync"></i></button>
            </form>
        </div>
        @empty
        <div style="text-align:center;padding:48px;background:#fff;border-radius:16px;border:1px solid #e2e8f0;color:#94a3b8;">
            <i class="fas fa-chart-line" style="font-size:40px;color:#e2e8f0;display:block;margin-bottom:8px;"></i>
            No progress reports yet
        </div>
        @endforelse
    </div>
</div>
@endsection
