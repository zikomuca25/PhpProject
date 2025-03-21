<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script type="module" src="app.js"></script>
    <script type="module" src="bootstrap.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
 

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-container {
            display: flex;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
        }
        .form-section {
            flex: 1;
            padding: 20px;
        }
        .image-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-login {
            background-color: #6c5ce7;
            color: white;
        }
        .btn-login:hover {
            background-color: #4834d4;
        }
        .input-group-text {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Login Form -->
        <div class="form-section">
            <h3 class="mb-3">Login</h3>
             <!-- <p>Don't have an account? <a href="{{ route('register') }}" id="signup-link">Sign Up</a></p> -->

            <!-- Display Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" placeholder="you@example.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password 
                        <a href="{{ route('forgot.password') }}" id="forget-link" class="float-end">Forgot Password?</a>
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter 6 characters or more" required>
                        <span class="input-group-text" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <button type="submit" class="btn btn-login w-100">LOGIN</button>
            </form>
            
            <hr>
            <p class="text-center">or login with</p>
            <div class="d-flex justify-content-center">
                <a href="{{ route('auth.google') }}" class="btn btn-google d-flex align-items-center justify-content-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google">
                    Sign in with Google
                </a>
            </div>
        </div>
        
        <!-- Image Section -->
        <div class="image-section">
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#togglePassword").click(function() {
                let passwordField = $("#password");
                let passwordFieldType = passwordField.attr("type");
                let icon = $(this).find("i");

                if (passwordFieldType === "password") {
                    passwordField.attr("type", "text");
                    icon.removeClass("bi-eye").addClass("bi-eye-slash");
                } else {
                    passwordField.attr("type", "password");
                    icon.removeClass("bi-eye-slash").addClass("bi-eye");
                }
            });
        });
    </script>
       <script>
    (function() {
        history.pushState(null, null, location.href);
        window.onpopstate = function(event) {
            history.pushState(null, null, location.href);
        };
    })();
</script>
</body>
</html>
