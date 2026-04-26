@extends('layouts.admin')
@section('title', 'Manage Students')
@section('page-title', 'Students Management')

@section('content')
<div class="page-header">
    <h1 class="page-title">All Students</h1>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Student</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Roll No</th><th>Department</th>
                <th>Semester</th><th>Performance</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td style="font-weight:600;">{{ $student->user->name }}</td>
                <td>{{ $student->user->email }}</td>
                <td>{{ $student->roll_no }}</td>
                <td>{{ $student->department }}</td>
                <td>{{ $student->semester }}</td>
                <td>
                    @if($student->latestResult)
                        @if($student->latestResult->status === 'slow_learner')
                            <span class="badge badge-danger">Slow Learner ({{ $student->latestResult->percentage }}%)</span>
                        @elseif($student->latestResult->status === 'intermediate')
                            <span class="badge badge-warning">Intermediate ({{ $student->latestResult->percentage }}%)</span>
                        @else
                            <span class="badge badge-success">Advanced ({{ $student->latestResult->percentage }}%)</span>
                        @endif
                    @else
                        <span class="badge badge-info">Not Assessed</span>
                    @endif
                </td>
                <td>
                    @if($student->user->status === 'active')
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.students.toggle', $student->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn {{ $student->user->status === 'active' ? 'btn-warning' : 'btn-success' }} btn-sm">
                                <i class="fas fa-{{ $student->user->status === 'active' ? 'ban' : 'check' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.students.delete', $student->id) }}" method="POST" onsubmit="return confirm('Delete this student?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#94a3b8;padding:32px;">No students found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
