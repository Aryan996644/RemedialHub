<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - RemedialHub')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; min-height: 100vh; }
        .sidebar { width: 260px; background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%); min-height: 100vh; position: fixed; left: 0; top: 0; z-index: 40; transition: all 0.3s; }
        .sidebar-link { display: flex; align-items: center; padding: 12px 20px; color: #c7d2fe; text-decoration: none; font-size: 14px; transition: all 0.2s; border-left: 3px solid transparent; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(255,255,255,0.1); color: #fff; border-left-color: #818cf8; }
        .sidebar-link i { width: 20px; margin-right: 12px; text-align: center; }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar { background: #fff; padding: 16px 32px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 30; }
        .stat-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); transition: all 0.3s; border: 1px solid #e2e8f0; }
        .stat-card:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.1); transform: translateY(-2px); }
        .badge { padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-block; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-purple { background: #ede9fe; color: #5b21b6; }
        .table-container { background: #fff; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden; border: 1px solid #e2e8f0; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; }
        td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155; }
        tr:hover td { background: #f8fafc; }
        .btn { padding: 8px 20px; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
        .btn-primary { background: #4f46e5; color: #fff; }
        .btn-primary:hover { background: #4338ca; }
        .btn-success { background: #059669; color: #fff; }
        .btn-success:hover { background: #047857; }
        .btn-danger { background: #dc2626; color: #fff; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-warning { background: #d97706; color: #fff; }
        .btn-warning:hover { background: #b45309; }
        .btn-sm { padding: 4px 12px; font-size: 12px; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-input { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: all 0.2s; outline: none; font-family: 'Inter', sans-serif; }
        .form-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        select.form-input { appearance: auto; }
        .alert { padding: 12px 20px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-info { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-title { font-size: 24px; font-weight: 700; color: #1e293b; }
        .card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; margin-bottom: 24px; }
        .card-title { font-size: 16px; font-weight: 600; color: #1e293b; margin-bottom: 16px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 24px; }
        @media (max-width: 1200px) { .grid-4 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .grid-4, .grid-3, .grid-2 { grid-template-columns: 1fr; } .sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div style="padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <a href="{{ route('admin.dashboard') }}" style="text-decoration: none;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #818cf8, #6366f1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-graduation-cap" style="color: #fff; font-size: 16px;"></i>
                    </div>
                    <div>
                        <div style="color: #fff; font-weight: 700; font-size: 16px;">RemedialHub</div>
                        <div style="color: #a5b4fc; font-size: 11px;">Admin Portal</div>
                    </div>
                </div>
            </a>
        </div>
        <nav style="padding: 12px 0;">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="{{ route('admin.teachers') }}" class="sidebar-link {{ request()->routeIs('admin.teachers*') ? 'active' : '' }}"><i class="fas fa-chalkboard-teacher"></i> Teachers</a>
            <a href="{{ route('admin.students') }}" class="sidebar-link {{ request()->routeIs('admin.students*') ? 'active' : '' }}"><i class="fas fa-user-graduate"></i> Students</a>
            <a href="{{ route('admin.courses') }}" class="sidebar-link {{ request()->routeIs('admin.courses*') ? 'active' : '' }}"><i class="fas fa-book-open"></i> Courses</a>
            <a href="{{ route('admin.assessments') }}" class="sidebar-link {{ request()->routeIs('admin.assessments*') ? 'active' : '' }}"><i class="fas fa-clipboard-check"></i> Assessments</a>
            <a href="{{ route('admin.slow-learners') }}" class="sidebar-link {{ request()->routeIs('admin.slow-learners') ? 'active' : '' }}"><i class="fas fa-exclamation-triangle"></i> Slow Learners</a>
            <a href="{{ route('admin.remedial-classes') }}" class="sidebar-link {{ request()->routeIs('admin.remedial-classes') ? 'active' : '' }}"><i class="fas fa-video"></i> Remedial Classes</a>
            <a href="{{ route('admin.assignments') }}" class="sidebar-link {{ request()->routeIs('admin.assignments') ? 'active' : '' }}"><i class="fas fa-tasks"></i> Assignments</a>
            <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Progress Reports</a>
            <div style="border-top: 1px solid rgba(255,255,255,0.1); margin: 12px 0;"></div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link" style="width: 100%; background: none; border: none; cursor: pointer; font-family: inherit; font-size: inherit;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <div>
                <h2 style="font-size: 18px; font-weight: 600; color: #1e293b;">@yield('page-title', 'Dashboard')</h2>
            </div>
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; background: #ede9fe; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user" style="color: #6366f1; font-size: 14px;"></i>
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ auth()->user()->name }}</div>
                        <div style="font-size: 12px; color: #64748b;">Administrator</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding: 24px 32px;">
            @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    <ul style="list-style: none;">
                        @foreach($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
