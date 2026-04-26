@extends('layouts.student')
@section('title', $assessment->title)
@section('page-title', $assessment->title)

@section('styles')
<style>
    .option-label { display:flex;align-items:center;gap:12px;padding:14px 16px;border:2px solid #e2e8f0;border-radius:12px;cursor:pointer;transition:all 0.2s;margin-bottom:10px;background:#fff; }
    .option-label:hover { border-color:#6366f1;background:#f5f3ff; }
    input[type=radio]:checked + .option-label { border-color:#6366f1;background:#ede9fe; }
    input[type=radio] { display:none; }
    .question-card { background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;margin-bottom:20px;box-shadow:0 1px 3px rgba(0,0,0,0.05); }
    #timer { font-size:20px;font-weight:700;color:#dc2626;background:#fee2e2;padding:8px 20px;border-radius:10px; }
    #timer.warning { animation:pulse 1s infinite; }
    @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:0.5;} }
</style>
@endsection

@section('content')
<!-- Test Header -->
<div style="background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:16px;padding:20px 28px;margin-bottom:24px;color:#fff;display:flex;justify-content:space-between;align-items:center;">
    <div>
        <h2 style="font-size:20px;font-weight:700;">{{ $assessment->title }}</h2>
        <div style="opacity:0.85;font-size:14px;margin-top:4px;">
            <i class="fas fa-question-circle"></i> {{ $questions->count() }} Questions &nbsp;
            <i class="fas fa-star"></i> {{ $assessment->total_marks }} Marks &nbsp;
            <i class="fas fa-tag"></i> {{ $assessment->category }}
        </div>
    </div>
    <div style="text-align:center;">
        <div style="font-size:12px;opacity:0.7;margin-bottom:4px;">Time Remaining</div>
        <div id="timer">{{ $assessment->duration }}:00</div>
    </div>
</div>

<!-- Progress Bar -->
<div style="background:#e2e8f0;border-radius:9999px;height:6px;margin-bottom:24px;overflow:hidden;">
    <div id="progress-bar" style="height:100%;background:linear-gradient(90deg,#6366f1,#8b5cf6);border-radius:9999px;transition:width 0.3s;width:0%;"></div>
</div>

<form method="POST" action="{{ route('student.assessment.submit', $assessment->id) }}" id="test-form">
    @csrf
    @foreach($questions as $i => $question)
    <div class="question-card" id="q-{{ $i+1 }}">
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:16px;">
            <div style="width:32px;height:32px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-weight:700;color:#fff;font-size:14px;">{{ $i+1 }}</div>
            <div style="font-size:15px;font-weight:600;color:#1e293b;line-height:1.5;">{{ $question->question }}</div>
        </div>
        <div>
            @foreach(['a'=>$question->option_a,'b'=>$question->option_b,'c'=>$question->option_c,'d'=>$question->option_d] as $letter=>$option)
            <div>
                <input type="radio" name="question_{{ $question->id }}" value="{{ $letter }}" id="q{{ $question->id }}_{{ $letter }}" onchange="updateProgress()">
                <label for="q{{ $question->id }}_{{ $letter }}" class="option-label">
                    <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#e2e8f0,#cbd5e1);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#475569;flex-shrink:0;">{{ strtoupper($letter) }}</div>
                    <span style="font-size:14px;color:#334155;">{{ $option }}</span>
                </label>
            </div>
            @endforeach
        </div>
        <div style="font-size:12px;color:#94a3b8;margin-top:8px;"><i class="fas fa-star" style="color:#d97706;"></i> {{ $question->marks }} mark(s)</div>
    </div>
    @endforeach

    <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;">
        <div style="font-size:14px;color:#64748b;">
            <span id="answered-count">0</span> / {{ $questions->count() }} answered
        </div>
        <button type="submit" class="btn btn-primary" style="font-size:16px;padding:14px 32px;" onclick="return confirm('Submit the test? You cannot change answers after submission.')">
            <i class="fas fa-paper-plane"></i> Submit Test
        </button>
    </div>
</form>

@endsection

@section('scripts')
<script>
const totalMin = {{ $assessment->duration }};
let totalSeconds = totalMin * 60;
const totalQuestions = {{ $questions->count() }};

// Timer
const timerEl = document.getElementById('timer');
const timerInterval = setInterval(() => {
    totalSeconds--;
    const m = Math.floor(totalSeconds / 60);
    const s = totalSeconds % 60;
    timerEl.textContent = m.toString().padStart(2,'0') + ':' + s.toString().padStart(2,'0');
    if (totalSeconds <= 60) timerEl.classList.add('warning');
    if (totalSeconds <= 0) {
        clearInterval(timerInterval);
        document.getElementById('test-form').submit();
    }
}, 1000);

// Progress
function updateProgress() {
    let answered = document.querySelectorAll('input[type=radio]:checked').length;
    document.getElementById('answered-count').textContent = answered;
    document.getElementById('progress-bar').style.width = (answered / totalQuestions * 100) + '%';
}
</script>
@endsection
