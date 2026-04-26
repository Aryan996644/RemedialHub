@extends('layouts.teacher')
@section('title', 'My Courses')
@section('page-title', 'Course Management')

@section('content')
<div class="page-header">
    <h1 class="page-title">My Courses</h1>
    <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create Course</a>
</div>

<div class="table-container">
    <table>
        <thead><tr><th>Title</th><th>Category</th><th>Level</th><th>Duration</th><th>Videos</th><th>Articles</th><th>Enrollments</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($courses as $course)
            <tr>
                <td style="font-weight:600;">{{ $course->title }}</td>
                <td>{{ $course->category }}</td>
                <td>
                    @if($course->level === 'beginner')<span class="badge badge-success">Beginner</span>
                    @elseif($course->level === 'intermediate')<span class="badge badge-warning">Intermediate</span>
                    @else<span class="badge badge-purple">Advanced</span>@endif
                </td>
                <td>{{ $course->duration ?? '-' }}</td>
                <td><span class="badge badge-info">{{ $course->videos_count }}</span></td>
                <td><span class="badge badge-info">{{ $course->articles_count }}</span></td>
                <td><span class="badge badge-purple">{{ $course->enrollments_count }}</span></td>
                <td>
                    @if($course->status === 'approved')<span class="badge badge-success">Approved</span>
                    @elseif($course->status === 'pending')<span class="badge badge-warning">Pending</span>
                    @elseif($course->status === 'rejected')<span class="badge badge-danger">Rejected</span>
                    @else<span class="badge badge-info">{{ ucfirst($course->status) }}</span>@endif
                </td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('teacher.courses.show', $course->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Delete this course?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:#94a3b8;padding:32px;">No courses yet. <a href="{{ route('teacher.courses.create') }}">Create your first course</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
