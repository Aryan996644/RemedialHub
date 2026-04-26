<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - RemedialHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #0f0a2a 0%, #1e1b4b 50%, #312e81 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-container { width: 100%; max-width: 440px; padding: 20px; }
        .login-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 48px 40px; }
        .login-header { text-align: center; margin-bottom: 36px; }
        .login-icon { width: 64px; height: 64px; background: linear-gradient(135deg, #6366f1, #4f46e5); border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; box-shadow: 0 10px 30px rgba(99,102,241,0.3); }
        .login-icon i { font-size: 28px; color: #fff; }
        h1 { color: #fff; font-size: 24px; font-weight: 700; margin-bottom: 8px; }
        .subtitle { color: #a5b4fc; font-size: 14px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; color: #c7d2fe; font-size: 13px; font-weight: 500; margin-bottom: 8px; }
        .form-input { width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; color: #fff; font-size: 14px; outline: none; transition: all 0.3s; font-family: 'Inter', sans-serif; }
        .form-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.2); }
        .form-input::placeholder { color: #64748b; }
        .login-btn { width: 100%; padding: 14px; background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; border-radius: 10px; color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-family: 'Inter', sans-serif; }
        .login-btn:hover { background: linear-gradient(135deg, #4f46e5, #4338ca); transform: translateY(-1px); box-shadow: 0 10px 25px rgba(99,102,241,0.3); }
        .back-link { display: block; text-align: center; margin-top: 24px; color: #a5b4fc; text-decoration: none; font-size: 14px; transition: color 0.2s; }
        .back-link:hover { color: #fff; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; }
        .alert-error { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon"><i class="fas fa-shield-alt"></i></div>
                <h1>Admin Login</h1>
                <p class="subtitle">Access the admin control panel</p>
            </div>

            @if(session('error'))
                <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="role" value="admin">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="admin@example.com" required value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login to Admin Panel</button>
            </form>
            <a href="{{ route('welcome') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Home</a>
        </div>
    </div>
</body>
</html>
