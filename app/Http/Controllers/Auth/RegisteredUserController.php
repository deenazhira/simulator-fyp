<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // In App\Http\Controllers\Auth\RegisteredUserController.php

public function store(Request $request)
{
    // 1. Validate (Note: user_name matching your DB column names)
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,user_email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'trainer_email' => ['nullable', 'email', 'exists:users,user_email'], // Check if trainer exists
    ]);

    // 2. Logic to Find Trainer
    $role = 'public';
    $trainerId = null;

    if ($request->filled('trainer_email')) {
        // Find the trainer by email
        $trainer = User::where('user_email', $request->trainer_email)
                       ->where('user_role', 'trainer')
                       ->first();

        if ($trainer) {
            $role = 'enterprise'; // They become 'Enterprise/Staff' status
            $trainerId = $trainer->user_id;
        }
    }

    // 3. Create User
    User::create([
        'user_name' => $request->name,
        'user_email' => $request->email,
        'user_password' => Hash::make($request->password),
        'user_role' => $role,      // 'public' or 'enterprise'
        'trainer_id' => $trainerId, // Linked ID or NULL
    ]);

    return redirect('/login')->with('success', 'Account created successfully. Please login.');
}
}
