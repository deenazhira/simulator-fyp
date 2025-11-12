<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    // 10 placeholder questions
    private $questions = [
        [
            'title' => 'Is this email phishing or legitimate?',
            'image' => 'images/email1.png',
        ],
        [
            'title' => 'This social media message link looks suspicious. Phishing or Legit?',
            'image' => 'images/email2.png',
        ],
        [
            'title' => 'You received a message claiming you won a prize. Is it phishing?',
            'image' => 'images/email3.png',
        ],
        [
            'title' => 'An email asks for your password to verify your account. Phishing or Legit?',
            'image' => 'images/email4.png',
        ],
        [
            'title' => 'A colleague sends a strange attachment unexpectedly. Safe or Suspicious?',
            'image' => 'images/email5.png',
        ],
        [
            'title' => 'A website asks you to login via a link sent in chat. Phishing or Legit?',
            'image' => 'images/email6.png',
        ],
        [
            'title' => 'You receive an urgent email from “IT support” asking for credentials. Safe?',
            'image' => 'images/email7.png',
        ],
        [
            'title' => 'A notification claims you need to reset your password now. Phishing or Legit?',
            'image' => 'images/email8.png',
        ],
        [
            'title' => 'A random email asks to verify payment details. Safe or Suspicious?',
            'image' => 'images/email9.png',
        ],
        [
            'title' => 'You get a message from an unknown sender with a link. Phishing or Legit?',
            'image' => 'images/email10.png',
        ],
    ];

    // Show quiz welcome page
    public function welcome()
    {
        return view('quiz-welcome'); // Make sure this blade exists
    }

    // Show specific question
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

    // Save answer and go to next question
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
}
