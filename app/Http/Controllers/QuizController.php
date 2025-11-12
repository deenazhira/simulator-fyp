<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    private $questions = [
        [
            'title' => 'Is this email phishing or legitimate?',
            'image' => 'images/email1.png',
        ],
        [
            'title' => 'This social media message link looks suspicious. Phishing or Legit?',
            'image' => 'images/email2.png',
        ],
        // Add all 10 questions here
    ];

    public function showQuestion(Request $request, $q = 1)
    {
        $q = (int) $q;

        if ($q > count($this->questions)) {
            // Quiz finished
            return view('quiz-finish');
        }

        $question = $this->questions[$q - 1];
        $total = count($this->questions);

        return view('quiz', compact('question', 'total', 'q'));
    }

    public function answer(Request $request)
    {
        $q = $request->input('question_number');
        $answer = $request->input('answer');

        // Save answer to session
        $answers = session()->get('quiz_answers', []);
        $answers[$q] = $answer;
        session(['quiz_answers' => $answers]);

        // Redirect to next question
        $next = $q + 1;
        return redirect()->route('quiz.start', ['q' => $next]);
    }

    public function welcome()
    {
        return view('quiz-welcome'); // Make sure this blade exists
    }
}
