<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\QuizResult; // Assuming you have this model

class TrainerDashboardController extends Controller
{
    public function index()
    {
        // 1. Get the Trainer
        $trainer = Auth::user();

        // 2. Get all Users linked to this Trainer
        $users = User::where('trainer_id', $trainer->user_id)->get();

        // 3. Calculate Stats
        $totalUsers = $users->count();
        $highRiskCount = 0;
        $lowRiskCount = 0;

        // Prepare data for the table
        $userStats = $users->map(function($user) use (&$highRiskCount, &$lowRiskCount) {
            // Get average quiz score for this user
            $avgScore = \DB::table('quiz_results')->where('user_id', $user->user_id)->avg('score') ?? 0;

            // Determine Risk
            // Logic: Less than 50% avg score = High Risk
            $risk = 'Medium';
            $riskColor = 'yellow';

            if ($avgScore >= 80) {
                $risk = 'Low Risk';
                $riskColor = 'green';
                $lowRiskCount++;
            } elseif ($avgScore < 50) {
                $risk = 'High Risk';
                $riskColor = 'red';
                $highRiskCount++;
            }

            return [
                'id' => $user->user_id,
                'name' => $user->user_name, // or 'name' depending on your column
                'email' => $user->user_email,
                'department' => 'IT Dept', // You might need to add this column to users table later
                'staff_id' => 'STF'. $user->user_id, // Placeholder if you don't have staff_id col
                'avg_score' => round($avgScore, 1),
                'risk' => $risk,
                'risk_color' => $riskColor
            ];
        });

        return view('dashboard.trainer', compact('totalUsers', 'highRiskCount', 'lowRiskCount', 'userStats'));
    }
}

