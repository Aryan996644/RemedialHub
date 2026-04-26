@extends('layouts.teacher')
@section('title', 'Assignments')
@section('page-title', 'Assignments')

@section('content')
<div class="grid-2">
    <!-- Create Assignment -->
    <div class="card">
        <div class="card-title"><i class="fas fa-plus-circle" style="color:#d97706;"></i> Create Assignment</div>
        <form method="POST" action="{{ route('teacher.assignments.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Assignment Title</label>
                <input type="text" name="title" class="form-input" required placeholder="e.g., Basic Programming Practice">
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
            <div class="form-group">
                <label class="form-label">Assign to Student</label>
                <select name="student_id" class="form-input" required>
                    <option value="">-- Select Student --</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}">{{ $s->user->name }} ({{ $s->roll_no }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Description / Instructions</label>
                <textarea name="description" class="form-input" rows="4" placeholder="Explain what students need to do..."></textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div class="form-group">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-input" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Total Marks</label>
                    <input type="number" name="marks" class="form-input" required min="1" value="50">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Create Assignment</button>
        </form>
    </div>

    <!-- Assignments List -->
    <div class="card">
        <div class="card-title"><i class="fas fa-list" style="color:#d97706;"></i> All Assignments ({{ $assignments->count() }})</div>
        <div style="max-height:620px;overflow-y:auto;">
            @forelse($assignments as $a)
            <div style="padding:14px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:10px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px;">
                    <div>
                        <div style="font-weight:600;font-size:14px;">{{ $a->title }}</div>
                        <div style="font-size:12px;color:#6366f1;">{{ $a->course->title }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;">
                            <i class="fas fa-user"></i> {{ $a->student->user->name }} &nbsp;
                            <i class="fas fa-calendar"></i> Due: {{ $a->due_date->format('M d, Y') }} &nbsp;
                            <i class="fas fa-star"></i> {{ $a->marks }} marks
                        </div>
                    </div>
                    @if($a->status === 'graded')<span class="badge badge-success">Graded</span>
                    @elseif($a->status === 'submitted')<span class="badge badge-info">Submitted</span>
                    @else<span class="badge badge-warning">Pending</span>@endif
                </div>
                <form action="{{ route('teacher.assignments.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Delete?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                </form>
            </div>
            @empty
            <div style="text-align:center;color:#94a3b8;padding:48px;">
                <i class="fas fa-tasks" style="font-size:40px;color:#e2e8f0;display:block;margin-bottom:8px;"></i>
                No assignments created yet
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
