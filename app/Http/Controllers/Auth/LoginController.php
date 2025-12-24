<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle the login request.
     */
    public function store(Request $request)
    {
        // 1. Validate inputs (using your custom field names)
        $credentials = $request->validate([
            'user_email' => ['required', 'email'],
            'user_password' => ['required'],
        ]);

        // 2. Attempt to Log In
        // We have to map your form input 'user_password' to the internal key 'password'
        // because Laravel's Auth::attempt expects 'password' as the key for the secret.
        if (Auth::attempt([
            'user_email' => $credentials['user_email'],
            'password' => $credentials['user_password'] // Map user_password to password
        ])) {

            // 3. Login Success
            $request->session()->regenerate();

            // Redirect based on role (Optional but cool)
            $role = Auth::user()->user_role;
            if($role === 'trainer') {
                return redirect()->intended('dashboard'); // Trainer Dashboard
            }

            return redirect()->intended(route('home')); // Normal User Home
        }

        // 4. Login Failed
        return back()->withErrors([
            'user_email' => 'The provided credentials do not match our records.',
        ])->onlyInput('user_email');
    }

    /**
     * Log the user out.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
