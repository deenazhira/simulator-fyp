<?php

namespace App\Http\Controllers\TrainerAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredTrainerController extends Controller
{
    /**
     * Display the registration view for Trainers.
     */
    public function create(): View
    {
        return view('auth.trainer-register'); // Matches your blade file name
    }

    /**
     * Handle an incoming Trainer registration request.
     */
    public function store(Request $request)
    {
        // 1. Validate the inputs
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            // Note: We check uniqueness against the 'user_email' column
            'email' => ['required', 'email', 'unique:users,user_email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Create the User (Mapping inputs to your DB columns)
        User::create([
            'user_name' => $request->name,
            'user_email' => $request->email,
            'user_password' => Hash::make($request->password),

            // Hardcode the role for this form
            'user_role' => 'trainer',

            // Save the company name
            'company_name' => $request->company_name,

            // Trainers do not have a boss, so this is null
            'trainer_id' => null,
        ]);

        // 3. Redirect to login
        return redirect('/login')->with('success', 'Trainer Account created! Please login.');
    }
}

