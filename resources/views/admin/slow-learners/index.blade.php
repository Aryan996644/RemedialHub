@extends('layouts.admin')
@section('title', 'Slow Learners')
@section('page-title', 'Slow Learner Report')

@section('content')
<div style="background:linear-gradient(135deg,#fef2f2,#fee2e2);border:1px solid #fecaca;border-radius:16px;padding:24px;margin-bottom:24px;display:flex;align-items:center;gap:16px;">
    <div style="width:56px;height:56px;background:#dc2626;border-radius:14px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-exclamation-triangle" style="color:#fff;font-size:24px;"></i>
    </div>
    <div>
        <div style="font-size:20px;font-weight:700;color:#991b1b;">{{ $slowLearners->count() }} Slow Learners Identified</div>
        <div style="color:#b91c1c;font-size:14px;">Students scoring below 40% need immediate remedial support</div>
    </div>
</div>

<!-- Filters -->
<div class="card">
    <form method="GET" action="{{ route('admin.slow-learners') }}" style="display:flex;gap:16px;align-items:flex-end;flex-wrap:wrap;">
        <div style="flex:1;min-width:180px;">
            <label class="form-label">Filter by Department</label>
            <select name="department" class="form-input">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                @endforeach
            </select>
        </div>
        <div style="flex:1;min-width:180px;">
            <label class="form-label">Filter by Category</label>
            <select name="category" class="form-input">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
        <a href="{{ route('admin.slow-learners') }}" class="btn" style="background:#e2e8f0;color:#475569;">Reset</a>
    </form>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr><th>Student</th><th>Dept</th><th>Assessment</th><th>Category</th><th>Score</th><th>Percentage</th><th>Skill Level</th><th>Teacher</th></tr>
        </thead>
        <tbody>
            @forelse($slowLearners as $r)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $r->student->user->name }}</div>
                    <div style="font-size:12px;color:#64748b;">{{ $r->student->roll_no }}</div>
                </td>
                <td>{{ $r->student->department }}</td>
                <td>{{ $r->assessment->title }}</td>
                <td>{{ $r->assessment->category }}</td>
                <td>{{ $r->score }} / {{ $r->total_marks }}</td>
                <td><span class="badge badge-danger">{{ $r->percentage }}%</span></td>
                <td><span class="badge badge-warning">{{ ucfirst($r->skill_level) }}</span></td>
                <td>{{ $r->assessment->teacher->user->name }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#94a3b8;padding:32px;">
                <i class="fas fa-check-circle" style="color:#059669;font-size:32px;margin-bottom:8px;display:block;"></i>
                No slow learners found!
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
