<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Gym Helper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card shadow p-4" style="max-width: 400px; width: 100%;">
    <h3 class="text-center mb-4">Login with Code</h3>
    
    <form action="{{ route('guest.authenticate') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Enter your Secret Code</label>
            <input type="text" name="session_token" class="form-control" placeholder="e.g. gym_AbCd123..." required>
            @error('session_token')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
        <div class="text-center mt-3">
            <a href="{{ route('dashboard') }}" class="text-muted">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>