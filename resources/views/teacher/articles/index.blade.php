@extends('layouts.teacher')
@section('title', 'Articles & Notes')
@section('page-title', 'Articles / Notes')

@section('content')
<div class="grid-2">
    <!-- Add Article Form -->
    <div class="card">
        <div class="card-title"><i class="fas fa-plus-circle" style="color:#6366f1;"></i> Add Article / Note</div>
        <form method="POST" action="{{ route('teacher.articles.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Select Course</label>
                <select name="course_id" class="form-input" required>
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Article Title</label>
                <input type="text" name="title" class="form-input" required placeholder="e.g., Programming Basics Notes">
            </div>
            <div class="form-group">
                <label class="form-label">Content / Summary</label>
                <textarea name="content" class="form-input" rows="5" placeholder="Write the article content or summary..."></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Upload PDF / File (optional)</label>
                <input type="file" name="file" class="form-input" accept=".pdf,.doc,.docx">
            </div>
            <div class="form-group">
                <label class="form-label">Order Number</label>
                <input type="number" name="order_no" class="form-input" required min="1" value="1">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Add Article</button>
        </form>
    </div>

    <!-- Articles List -->
    <div class="card">
        <div class="card-title"><i class="fas fa-list" style="color:#6366f1;"></i> All Articles ({{ $articles->count() }})</div>
        @forelse($articles as $article)
        <div style="padding:12px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:8px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div style="flex:1;">
                    <div style="font-weight:600;font-size:14px;">{{ $article->order_no }}. {{ $article->title }}</div>
                    <div style="font-size:12px;color:#6366f1;margin-top:2px;">{{ $article->course->title }}</div>
                    @if($article->file_url)
                    <div style="font-size:12px;color:#059669;margin-top:2px;"><i class="fas fa-paperclip"></i> File attached</div>
                    @endif
                </div>
                <div style="display:flex;gap:4px;">
                    <a href="{{ route('teacher.articles.edit', $article->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('teacher.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p style="color:#94a3b8;font-size:14px;text-align:center;padding:32px;">No articles added yet</p>
        @endforelse
    </div>
</div>
@endsection
