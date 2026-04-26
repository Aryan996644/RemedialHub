@extends('layouts.student')
@section('title', 'Skill Assessment')
@section('page-title', 'Skill Assessment Center')

@section('content')
<div style="max-width:800px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:40px;">
        <div style="width:72px;height:72px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:20px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:0 10px 30px rgba(99,102,241,0.3);">
            <i class="fas fa-clipboard-check" style="color:#fff;font-size:32px;"></i>
        </div>
        <h2 style="font-size:26px;font-weight:700;color:#1e293b;margin-bottom:8px;">Skill Assessment Center</h2>
        <p style="color:#64748b;font-size:16px;">Take an assessment to identify your skill level and receive personalized course recommendations.</p>
    </div>

    <!-- Info Box -->
    <div style="background:linear-gradient(135deg,#ede9fe,#e0e7ff);border-radius:16px;padding:20px 24px;margin-bottom:32px;border:1px solid #c7d2fe;">
        <div style="display:flex;gap:12px;align-items:flex-start;">
            <i class="fas fa-info-circle" style="color:#6366f1;font-size:20px;margin-top:2px;"></i>
            <div>
                <div style="font-weight:600;color:#3730a3;margin-bottom:4px;">How it works</div>
                <ul style="color:#4338ca;font-size:14px;line-height:1.8;padding-left:16px;">
                    <li>Select an assessment and answer all MCQ questions</li>
                    <li>Score below 40% → Identified as <strong>Slow Learner</strong> → Beginner courses recommended</li>
                    <li>Score 40–70% → <strong>Intermediate</strong> → Mid-level courses recommended</li>
                    <li>Score above 70% → <strong>Advanced</strong> → Advanced courses recommended</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Available Assessments -->
    <div style="display:flex;flex-direction:column;gap:16px;">
        @forelse($assessments as $assessment)
        <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,0.05);display:flex;align-items:center;justify-content:space-between;gap:16px;">
            <div style="display:flex;align-items:center;gap:16px;">
                <div style="width:52px;height:52px;background:linear-gradient(135deg,#ede9fe,#c7d2fe);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-clipboard-list" style="color:#6366f1;font-size:22px;"></i>
                </div>
                <div>
                    <div style="font-size:17px;font-weight:700;color:#1e293b;margin-bottom:4px;">{{ $assessment->title }}</div>
                    <div style="display:flex;gap:16px;flex-wrap:wrap;">
                        <span style="font-size:13px;color:#64748b;"><i class="fas fa-tag" style="color:#6366f1;"></i> {{ $assessment->category }}</span>
                        <span style="font-size:13px;color:#64748b;"><i class="fas fa-question-circle" style="color:#3b82f6;"></i> {{ $assessment->questions_count }} Questions</span>
                        <span style="font-size:13px;color:#64748b;"><i class="fas fa-star" style="color:#d97706;"></i> {{ $assessment->total_marks }} Marks</span>
                        <span style="font-size:13px;color:#64748b;"><i class="fas fa-clock" style="color:#059669;"></i> {{ $assessment->duration }} min</span>
                    </div>
                </div>
            </div>
            <div style="flex-shrink:0;">
                @if($completedAssessmentIds->contains($assessment->id))
                    <span class="badge badge-success" style="font-size:13px;padding:8px 16px;"><i class="fas fa-check"></i> Completed</span>
                @elseif($assessment->questions_count === 0)
                    <span class="badge badge-warning" style="font-size:13px;padding:8px 16px;">No Questions Yet</span>
                @else
                    <a href="{{ route('student.assessment.test', $assessment->id) }}" class="btn btn-primary" style="font-size:14px;">
                        <i class="fas fa-play"></i> Start Test
                    </a>
                @endif
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:64px;background:#fff;border-radius:16px;border:1px solid #e2e8f0;">
            <i class="fas fa-clipboard-list" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px;"></i>
            <p style="color:#64748b;">No assessments available yet</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
