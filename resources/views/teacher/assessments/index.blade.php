@extends('layouts.teacher')
@section('title', 'Assessments')
@section('page-title', 'Assessments')

@section('content')
<div class="page-header">
    <h1 class="page-title">My Assessments</h1>
    <a href="{{ route('teacher.assessments.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create Assessment</a>
</div>

<div class="table-container">
    <table>
        <thead><tr><th>Title</th><th>Category</th><th>Total Marks</th><th>Duration</th><th>Questions</th><th>Attempts</th><th>Avg Score</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($assessments as $a)
            <tr>
                <td style="font-weight:600;">{{ $a->title }}</td>
                <td>{{ $a->category }}</td>
                <td>{{ $a->total_marks }}</td>
                <td>{{ $a->duration }} min</td>
                <td><span class="badge badge-info">{{ $a->questions_count }}</span></td>
                <td><span class="badge badge-purple">{{ $a->results_count }}</span></td>
                <td><span class="badge {{ $a->avg_score < 40 ? 'badge-danger' : ($a->avg_score <= 70 ? 'badge-warning' : 'badge-success') }}">{{ $a->avg_score }}%</span></td>
                <td>
                    @if($a->status === 'active')<span class="badge badge-success">Active</span>
                    @else<span class="badge badge-danger">Inactive</span>@endif
                </td>
                <td>
                    <div style="display:flex;gap:4px;">
                        <a href="{{ route('teacher.questions', ['assessment_id' => $a->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-question-circle"></i> Questions</a>
                        <a href="{{ route('teacher.assessments.edit', $a->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('teacher.assessments.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:#94a3b8;padding:32px;">No assessments yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
