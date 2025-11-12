<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Quiz welcome page
    public function welcome()
    {
        return view('quiz-welcome');
    }

    // Show the first question (or current question)
    public function showQuestion()
    {
        $question = [
            'title' => 'Is this email phishing or legitimate?',
            'image' => 'images/sample-email.png'
        ];

        $total = 5; // total questions
        $q = 1;     // current question

        return view('quiz', compact('question', 'total', 'q'));
    }

    public function answer(Request $request)
    {
        $question_number = $request->input('question_number');
        $answer = $request->input('answer');

        // Store in session or DB as needed
        return back()->with('message', 'Answer submitted for question ' . $question_number);
    }
}
