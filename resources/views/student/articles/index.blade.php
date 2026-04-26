@extends('layouts.student')
@section('title', 'Articles & Notes')
@section('page-title', 'Articles & Notes')

@section('content')
@if($articles->isEmpty())
<div style="text-align:center;padding:64px;background:#fff;border-radius:20px;border:1px solid #e2e8f0;">
    <i class="fas fa-file-alt" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px;"></i>
    <p style="color:#64748b;margin-bottom:16px;">No articles available. Enroll in a course first.</p>
    <a href="{{ route('student.recommended-courses') }}" class="btn btn-primary">Browse Recommended Courses</a>
</div>
@else
<div class="grid-2">
    @foreach($articles as $article)
    <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,0.05);display:flex;flex-direction:column;">
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
            <div style="width:44px;height:44px;background:linear-gradient(135deg,#dcfce7,#a7f3d0);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-file-alt" style="color:#059669;font-size:18px;"></i>
            </div>
            <div>
                <div style="font-weight:700;font-size:15px;color:#1e293b;margin-bottom:2px;">{{ $article->title }}</div>
                <div style="font-size:12px;color:#6366f1;"><i class="fas fa-book"></i> {{ $article->course->title }}</div>
            </div>
        </div>
        @if($article->content)
        <div style="font-size:14px;color:#475569;line-height:1.7;flex:1;">{{ $article->content }}</div>
        @endif
        @if($article->file_url)
        <a href="{{ asset('storage/' . $article->file_url) }}" target="_blank" class="btn btn-success btn-sm" style="margin-top:16px;align-self:flex-start;">
            <i class="fas fa-download"></i> Download PDF
        </a>
        @endif
    </div>
    @endforeach
</div>
@endif
@endsection
