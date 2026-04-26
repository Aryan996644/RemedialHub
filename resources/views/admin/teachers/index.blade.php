@extends('layouts.admin')
@section('title', 'Manage Teachers')
@section('page-title', 'Teachers Management')

@section('content')
<div class="page-header">
    <h1 class="page-title">All Teachers</h1>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Teacher</a>
</div>

<div class="table-container">
    <table>
        <thead><tr><th>Name</th><th>Email</th><th>Employee ID</th><th>Department</th><th>Subject</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($teachers as $teacher)
            <tr>
                <td style="font-weight:600;">{{ $teacher->user->name }}</td>
                <td>{{ $teacher->user->email }}</td>
                <td>{{ $teacher->employee_id }}</td>
                <td>{{ $teacher->department }}</td>
                <td>{{ $teacher->subject }}</td>
                <td>
                    @if($teacher->user->status === 'active')<span class="badge badge-success">Active</span>
                    @else<span class="badge badge-danger">Inactive</span>@endif
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.teachers.toggle', $teacher->id) }}" method="POST">@csrf @method('PATCH')
                            <button type="submit" class="btn {{ $teacher->user->status === 'active' ? 'btn-warning' : 'btn-success' }} btn-sm">
                                <i class="fas fa-{{ $teacher->user->status === 'active' ? 'ban' : 'check' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.teachers.delete', $teacher->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">@csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:32px;">No teachers found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
