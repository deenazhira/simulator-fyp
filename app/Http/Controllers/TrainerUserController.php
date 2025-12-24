<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TrainerUserController extends Controller
{
    // 1. Show the list of users (Matches your mockup)
    public function index()
    {
        $trainerId = Auth::user()->user_id;

        // Get all staff linked to this trainer
        $users = User::where('trainer_id', $trainerId)->get()->map(function($user) {
            // Calculate average score for the table
            $avgScore = \DB::table('quiz_results')->where('user_id', $user->user_id)->avg('score') ?? 0;

            return [
                'id' => $user->user_id,
                'name' => $user->user_name,
                'email' => $user->user_email,
                'department' => $user->company_name ?? 'General', // Using company_name as Dept
                'avg_score' => round($avgScore, 1),
                'staff_id' => 'STF' . str_pad($user->user_id, 4, '0', STR_PAD_LEFT)
            ];
        });

        return view('trainer.users.index', compact('users'));
    }

    // 2. Remove a user (Unlink them from the team)
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Security Check: Only remove if they belong to YOU
        if($user->trainer_id !== Auth::user()->user_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Unlink the user (Set trainer_id to NULL)
        $user->trainer_id = null;
        $user->save();

        return back()->with('success', 'User removed from your team.');
    }

    // 3. Show a specific user's activity (Profile & History)
    public function show($id)
    {
        // Find the user
        $user = User::findOrFail($id);

        // Security Check: Ensure this user belongs to the logged-in trainer
        if($user->trainer_id !== Auth::user()->user_id) {
            return redirect()->route('trainer.users.index')->with('error', 'Unauthorized access.');
        }

        // Fetch Quiz Results (using the table we just created)
        $quizResults = \DB::table('quiz_results')
                        ->where('user_id', $user->user_id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Calculate Stats
        $totalQuizzes = $quizResults->count();
        $avgScore = $quizResults->avg('score') ?? 0;

        // Determine Risk based on average
        $riskStatus = 'Medium';
        $riskColor = 'text-yellow-600 bg-yellow-100';

        if ($avgScore >= 80) {
            $riskStatus = 'Low Risk';
            $riskColor = 'text-green-600 bg-green-100';
        } elseif ($avgScore < 50 && $totalQuizzes > 0) {
            $riskStatus = 'High Risk';
            $riskColor = 'text-red-600 bg-red-100';
        }

        return view('trainer.users.show', compact('user', 'quizResults', 'avgScore', 'totalQuizzes', 'riskStatus', 'riskColor'));
    }
}

