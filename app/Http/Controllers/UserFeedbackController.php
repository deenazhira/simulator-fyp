<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserFeedbackController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->user_id;

        // Fetch all quiz attempts by this user
        // Join with trainer_feedback to see if feedback exists
        $results = DB::table('quiz_results')
            ->leftJoin('trainer_feedback', 'quiz_results.id', '=', 'trainer_feedback.quiz_result_id')
            ->leftJoin('users as trainers', 'trainer_feedback.trainer_id', '=', 'trainers.user_id')
            ->where('quiz_results.user_id', $userId)
            ->select(
                'quiz_results.id as result_id',
                'quiz_results.score',
                'quiz_results.created_at as quiz_date',
                'trainer_feedback.feedback_text',
                'trainer_feedback.recommended_action',
                'trainer_feedback.created_at as feedback_date',
                'trainers.user_name as trainer_name'
            )
            ->orderBy('quiz_results.created_at', 'desc')
            ->get();

        return view('user.feedback.index', compact('results'));
    }
}

