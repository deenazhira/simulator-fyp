<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class TrainerDashboardController extends Controller
{
    public function index()
    {
        // 1) Get trainer
        $trainer = Auth::user();

        // 2) Users under this trainer
        $users = User::where('trainer_id', $trainer->user_id)->get();
        $userIds = $users->pluck('user_id')->values();

        // 3) Stats
        $totalUsers = $users->count();
        $highRiskCount = 0;
        $lowRiskCount = 0;
        $mediumRiskCount = 0;

        // Table data
        $userStats = $users->map(function ($user) use (&$highRiskCount, &$lowRiskCount, &$mediumRiskCount) {

            $avgScore = DB::table('quiz_results')
                ->where('user_id', $user->user_id)
                ->avg('score') ?? 0;

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
            } else {
                $mediumRiskCount++;
            }

            return [
                'id' => $user->user_id,
                'name' => $user->user_name,
                'email' => $user->user_email,
                'department' => 'IT Dept',
                'staff_id' => 'STF' . $user->user_id,
                'avg_score' => round($avgScore, 1),
                'risk' => $risk,
                'risk_color' => $riskColor
            ];
        });

        // 4) Activity Chart: attempts per day (last 14 days)
        $days = 14;
        $activityLabels = [];
        $activityCounts = [];

        if ($userIds->count() > 0) {
            $countsByDate = DB::table('quiz_results')
                ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
                ->whereIn('user_id', $userIds)
                ->where('created_at', '>=', now()->subDays($days - 1))
                ->groupBy('d')
                ->pluck('c', 'd'); // ['2025-12-26' => 3, ...]

            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->toDateString();
                $activityLabels[] = $date;
                $activityCounts[] = (int) ($countsByDate[$date] ?? 0);
            }
        } else {
            for ($i = $days - 1; $i >= 0; $i--) {
                $activityLabels[] = now()->subDays($i)->toDateString();
                $activityCounts[] = 0;
            }
        }

        return view('dashboard.trainer', compact(
            'totalUsers',
            'highRiskCount',
            'mediumRiskCount',
            'lowRiskCount',
            'userStats',
            'activityLabels',
            'activityCounts'
        ));
    }
}
