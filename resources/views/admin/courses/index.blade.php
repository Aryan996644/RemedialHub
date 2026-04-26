@extends('layouts.admin')
@section('title', 'Courses')
@section('page-title', 'Course Management')

@section('content')
<div class="page-header">
    <h1 class="page-title">All Courses</h1>
    <div style="display:flex;gap:8px;">
        <span class="badge badge-warning" style="font-size:13px;padding:8px 16px;">Pending: {{ $courses->where('status','pending')->count() }}</span>
        <span class="badge badge-success" style="font-size:13px;padding:8px 16px;">Approved: {{ $courses->where('status','approved')->count() }}</span>
    </div>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr><th>Title</th><th>Teacher</th><th>Category</th><th>Level</th><th>Videos</th><th>Articles</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
            <tr>
                <td style="font-weight:600;">{{ $course->title }}</td>
                <td>{{ $course->teacher->user->name }}</td>
                <td>{{ $course->category }}</td>
                <td>
                    @if($course->level === 'beginner')<span class="badge badge-success">Beginner</span>
                    @elseif($course->level === 'intermediate')<span class="badge badge-warning">Intermediate</span>
                    @else<span class="badge badge-purple">Advanced</span>@endif
                </td>
                <td><span class="badge badge-info">{{ $course->videos_count }} Videos</span></td>
                <td><span class="badge badge-info">{{ $course->articles_count }} Articles</span></td>
                <td>
                    @if($course->status === 'approved')<span class="badge badge-success">Approved</span>
                    @elseif($course->status === 'pending')<span class="badge badge-warning">Pending</span>
                    @elseif($course->status === 'rejected')<span class="badge badge-danger">Rejected</span>
                    @elseif($course->status === 'active')<span class="badge badge-success">Active</span>
                    @else<span class="badge badge-danger">Inactive</span>@endif
                </td>
                <td>
                    <div style="display:flex;gap:6px;">
                        @if($course->status === 'pending')
                        <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST">@csrf @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Approve</button>
                        </form>
                        <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST">@csrf @method('PATCH')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Reject</button>
                        </form>
                        @else
                        <span style="color:#94a3b8;font-size:13px;">{{ ucfirst($course->status) }}</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#94a3b8;padding:32px;">No courses found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
