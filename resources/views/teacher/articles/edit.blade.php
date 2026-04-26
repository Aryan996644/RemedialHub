@extends('layouts.teacher')
@section('title', 'Edit Article')
@section('page-title', 'Edit Article')

@section('content')
<div class="card" style="max-width:680px;">
    <div class="card-title"><i class="fas fa-edit" style="color:#6366f1;"></i> Edit Article</div>
    <form method="POST" action="{{ route('teacher.articles.update', $article->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Select Course</label>
            <select name="course_id" class="form-input" required>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $article->course_id == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Article Title</label>
            <input type="text" name="title" class="form-input" required value="{{ $article->title }}">
        </div>
        <div class="form-group">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-input" rows="6">{{ $article->content }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Replace File (optional)</label>
            <input type="file" name="file" class="form-input" accept=".pdf,.doc,.docx">
        </div>
        <div class="form-group">
            <label class="form-label">Order Number</label>
            <input type="number" name="order_no" class="form-input" required min="1" value="{{ $article->order_no }}">
        </div>
        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Article</button>
            <a href="{{ route('teacher.articles') }}" class="btn" style="background:#e2e8f0;color:#475569;">Cancel</a>
        </div>
    </form>
</div>
@endsection
