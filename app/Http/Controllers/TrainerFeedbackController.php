<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class TrainerFeedbackController extends Controller
{
    // 1. Show the Feedback Form
    public function create($quiz_result_id)
    {
        // Fetch the quiz details to show in the "Read-Only" section
        $quizResult = DB::table('quiz_results')->where('id', $quiz_result_id)->first();

        if (!$quizResult) {
            return back()->with('error', 'Quiz result not found.');
        }

        $user = User::findOrFail($quizResult->user_id);

        // Security Check
        if ($user->trainer_id !== Auth::user()->user_id) {
            return back()->with('error', 'Unauthorized.');
        }

        return view('trainer.feedback.create', compact('quizResult', 'user'));
    }

    // 2. Save the Feedback
    public function store(Request $request)
    {
        $request->validate([
            'quiz_result_id' => 'required',
            'user_id' => 'required',
            'feedback_text' => 'required|string',
            'recommended_action' => 'required|string',
        ]);

        DB::table('trainer_feedback')->insert([
            'user_id' => $request->user_id,
            'trainer_id' => Auth::user()->user_id,
            'quiz_result_id' => $request->quiz_result_id,
            'feedback_text' => $request->feedback_text,
            'recommended_action' => $request->recommended_action,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect back to the User Activity page with a success message
        return redirect()->route('trainer.users.show', $request->user_id)
                         ->with('success', 'Feedback submitted successfully!');
    }
}

