<?php

namespace App\Http\Controllers\TrainerAuth;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredTrainerController extends Controller
{
    public function create()
    {
        return view('auth.trainer-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:trainers,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Trainer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // For now: redirect to login page (we will do trainer login next)
        return redirect('/login')->with('success', 'Trainer account created. Please log in.');
    }
}
