<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
        .signup-container {
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
        .btn-signup {
            background-color: #6c5ce7;
            color: white;
        }
        .btn-signup:hover {
            background-color: #4834d4;
        }
        .social-buttons img {
            width: 24px;
            margin-right: 5px;
        }
        .password-wrapper {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: gray;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <!-- Sign Up Form -->
        <div class="form-section">
            <h3 class="mb-3">Sign Up</h3>
            <p>Already have an account? <a href="{{ route('login') }}" id="login-link">Login</a></p>
            
            <!-- Show Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Laravel Form -->
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="username" class="form-control" placeholder="Your Full Name" required value="{{ old('username') }}">
                    @if ($errors->has('username'))
                        <div class="text-danger">{{ $errors->first('username') }}</div>
                    @endif
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="you@example.com" required value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <div class="text-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Role</label>
                    <select name="role" class="form-control" required>
                        <!--<option value="Employee" {{ old('role') == 'Employee' ? 'selected' : '' }}>Employee</option>
                        <option value="Administrator" {{ old('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>-->
                    </select>
                </div>
                
                <div class="mb-3 password-wrapper">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter 6 characters or more" required>
                    <span class="toggle-password" onclick="togglePassword('password')">&#128065;</span>
                    @if ($errors->has('password'))
                        <div class="text-danger">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                
                <div class="mb-3 password-wrapper">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Re-enter your password" required>
                    <span class="toggle-password" onclick="togglePassword('password_confirmation')">&#128065;</span>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" name="terms" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">I agree to the <a href="#">terms and conditions</a></label>
                </div>
                
                <button type="submit" class="btn btn-signup w-100">SIGN UP</button>
            </form>
        </div>
        
        <!-- Image Section -->
        <div class="image-section">
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#login-link').click(function(event) {
                event.preventDefault();
                window.location.href = '{{ route("login") }}';
            });
        });

        function togglePassword(fieldId) {
            let field = document.getElementById(fieldId);
            field.type = field.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
