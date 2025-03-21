<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script type="module" src="app.js"></script>
    <script type="module" src="bootstrap.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .forgot-password-container {
            display: flex;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-reset {
            background-color: #6c5ce7;
            color: white;
        }
        .btn-reset:hover {
            background-color: #4834d4;
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <div class="w-100">
            <h3 class="mb-3">Forgot Password</h3>
            <p>Enter your email address below and we'll send you a link to reset your password.</p>

            <!-- Success and Error Messages -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form action="{{ route('forgot.password') }}" method="POST">
                @csrf
                <div class="mb-3 text-start">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                </div>
                <button type="submit" class="btn btn-reset w-100">Send Reset Link</button>
            </form>

            <hr>
            <p><a href="/">Back to Login</a></p>
        </div>
    </div>
</body>
</html>
