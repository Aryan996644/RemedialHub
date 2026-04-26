<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="RemedialHub - Bridging the Gap with Precision Remedial Learning">
    <title>RemedialHub - Precision Remedial Learning</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0f0a2a; color: #fff; min-height: 100vh; overflow-x: hidden; }
        .hero { min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; padding: 40px 20px; }
        .hero::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 50%, rgba(99,102,241,0.15) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(139,92,246,0.1) 0%, transparent 50%), radial-gradient(circle at 50% 80%, rgba(59,130,246,0.1) 0%, transparent 50%); }
        .hero > * { position: relative; z-index: 1; }
        .logo-section { text-align: center; margin-bottom: 48px; }
        .logo-icon { width: 72px; height: 72px; background: linear-gradient(135deg, #6366f1, #8b5cf6, #a78bfa); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; box-shadow: 0 20px 40px rgba(99,102,241,0.3); }
        .logo-icon i { font-size: 32px; color: #fff; }
        .app-name { font-size: 42px; font-weight: 800; background: linear-gradient(135deg, #c7d2fe, #fff, #a5b4fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: -1px; }
        .tagline { font-size: 18px; color: #a5b4fc; margin-top: 12px; font-weight: 400; }
        .cards-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; max-width: 1000px; width: 100%; }
        .portal-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 40px 32px; text-align: center; transition: all 0.4s; backdrop-filter: blur(10px); }
        .portal-card:hover { background: rgba(255,255,255,0.1); border-color: rgba(129,140,248,0.4); transform: translateY(-8px); box-shadow: 0 30px 60px rgba(0,0,0,0.3); }
        .portal-icon { width: 64px; height: 64px; border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; }
        .portal-icon i { font-size: 28px; color: #fff; }
        .portal-card h3 { font-size: 22px; font-weight: 700; margin-bottom: 12px; color: #fff; }
        .portal-card p { font-size: 14px; color: #94a3b8; line-height: 1.6; margin-bottom: 28px; }
        .portal-btn { display: inline-block; padding: 12px 32px; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; color: #fff; transition: all 0.3s; }
        .portal-btn:hover { transform: scale(1.05); }
        .student-icon { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .student-btn { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .teacher-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .teacher-btn { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .admin-icon { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .admin-btn { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .floating-shapes div { position: absolute; border-radius: 50%; opacity: 0.05; background: #818cf8; }
        .floating-shapes .s1 { width: 300px; height: 300px; top: -100px; right: -100px; }
        .floating-shapes .s2 { width: 200px; height: 200px; bottom: -50px; left: -50px; }
        .floating-shapes .s3 { width: 150px; height: 150px; top: 50%; left: 10%; }
        @media (max-width: 768px) { .cards-grid { grid-template-columns: 1fr; max-width: 400px; } .app-name { font-size: 32px; } }
    </style>
</head>
<body>
    <div class="floating-shapes"><div class="s1"></div><div class="s2"></div><div class="s3"></div></div>

    <div class="hero">
        <div class="logo-section">
            <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
            <h1 class="app-name">RemedialHub</h1>
            <p class="tagline">Bridging the Gap with Precision Remedial Learning</p>
        </div>

        @if(session('error'))
            <div style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; padding: 12px 24px; border-radius: 10px; margin-bottom: 24px; font-size: 14px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="cards-grid">
            <div class="portal-card">
                <div class="portal-icon student-icon"><i class="fas fa-user-graduate"></i></div>
                <h3>Student Portal</h3>
                <p>Take skill assessments, access personalized courses, video lessons, and track your learning progress.</p>
                <a href="{{ route('student.login') }}" class="portal-btn student-btn">Enter Student Portal</a>
            </div>

            <div class="portal-card">
                <div class="portal-icon teacher-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h3>Teacher Portal</h3>
                <p>Create courses, assessments, schedule remedial classes, and monitor student improvement.</p>
                <a href="{{ route('teacher.login') }}" class="portal-btn teacher-btn">Enter Teacher Portal</a>
            </div>

            <div class="portal-card">
                <div class="portal-icon admin-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Admin Portal</h3>
                <p>Manage teachers, students, monitor slow learners, and oversee the entire platform.</p>
                <a href="{{ route('admin.login') }}" class="portal-btn admin-btn">Enter Admin Portal</a>
            </div>
        </div>
    </div>
</body>
</html>
