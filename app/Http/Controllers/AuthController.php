<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function showResetPasswordForm(Request $request)
    {
        return view('auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string|max:100|unique:users',
                'email' => 'required|email|max:150|unique:users',
                'password' => 'required|min:6|confirmed',
                'role' => 'required|in:Employee,Administrator'
            ]);

            $user = User::create([
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
            ]);

            return redirect()->route('login')->with('success', 'Account created successfully. Please log in.');
        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong.']);
        }
    }

   


public function login(Request $request) 
{
    $request->validate([
        'email' => 'required',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No account found with this email.']);
    }

    if (!Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
        return back()->withErrors(['password' => 'Incorrect password. Please try again.']);
    }

    $request->session()->regenerate();
    Log::info('User logged in:', ['user' => Auth::user()]);

    return redirect()->route($user->role === 'Employee' ? 'employee.dashboard' : 'admin.dashboard');
}


    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We could not find an account with that email.']);
        }

        $token = Str::random(60);
        $user->reset_token = Hash::make($token);
        $user->save();

        $resetLink = url('/reset-password?token=' . $token . '&email=' . $user->email);
        Mail::raw("Click here to reset your password: $resetLink", function ($message) use ($user) {
            $message->to($user->email)->subject('Reset Your Password');
        });

        return back()->with('status', 'A password reset link has been sent to your email.');
    }

    // Handle Google Login Redirection
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();
    
            if (!$user) {
                return redirect()->route('login')->withErrors([
                    'google' => 'No account is associated with this Google email. Please register first.',
                ]);
            }
    
            Auth::login($user);
            return redirect()->route($user->role === 'Employee' ? 'employee.dashboard' : 'admin.dashboard');
    
        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage());
    
            return redirect()->route('login')->withErrors([
                'google' => 'There was an issue with Google login. Please try again later.',
            ]);
        }
    }
    

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email.']);
        }
    
        if (!$user->reset_token) {
            return back()->withErrors(['token' => 'No active reset request found. Please request a new reset link.']);
        }
    
        if (!Hash::check($request->token, $user->reset_token)) {
            return back()->withErrors(['token' => 'This reset link is invalid or has expired. Please request a new one.']);
        }
    
        $user->password = Hash::make($request->password);
        $user->reset_token = null;
        $user->save();
    
        return redirect('/')->with('status', 'Your password has been successfully reset.');
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
