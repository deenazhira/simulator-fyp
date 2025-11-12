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
            'correct' => 'Phishing',
            'explanation' => 'This is a classic phishing attempt.'
        ],
        [
            'title' => 'This social media message link looks suspicious. Phishing or Legit?',
            'image' => 'images/email2.png',
            'correct' => 'Phishing',
            'explanation' => 'Suspicious links should never be clicked.'
        ],
        [
            'title' => 'You received a message claiming you won a prize. Is it phishing?',
            'image' => 'images/email3.png',
            'correct' => 'Phishing',
            'explanation' => 'Unexpected prize messages are usually scams.'
        ],
        [
            'title' => 'An email asks for your password to verify your account. Phishing or Legit?',
            'image' => 'images/email4.png',
            'correct' => 'Phishing',
            'explanation' => 'Legitimate companies never ask for passwords via email.'
        ],
        [
            'title' => 'A colleague sends a strange attachment unexpectedly. Safe or Suspicious?',
            'image' => 'images/email5.png',
            'correct' => 'Phishing',
            'explanation' => 'Unexpected attachments may contain malware.'
        ],
        [
            'title' => 'A website asks you to login via a link sent in chat. Phishing or Legit?',
            'image' => 'images/email6.png',
            'correct' => 'Phishing',
            'explanation' => 'Always navigate to websites manually, not via unknown links.'
        ],
        [
            'title' => 'You receive an urgent email from “IT support” asking for credentials. Safe?',
            'image' => 'images/email7.png',
            'correct' => 'Phishing',
            'explanation' => 'IT support will never ask for your credentials by email.'
        ],
        [
            'title' => 'A notification claims you need to reset your password now. Phishing or Legit?',
            'image' => 'images/email8.png',
            'correct' => 'Phishing',
            'explanation' => 'Legitimate password resets do not create panic.'
        ],
        [
            'title' => 'A random email asks to verify payment details. Safe or Suspicious?',
            'image' => 'images/email9.png',
            'correct' => 'Phishing',
            'explanation' => 'Never provide sensitive info to unknown emails.'
        ],
        [
            'title' => 'You get a message from an unknown sender with a link. Phishing or Legit?',
            'image' => 'images/email10.png',
            'correct' => 'Phishing',
            'explanation' => 'Unknown senders with links are always suspicious.'
        ],
    ];

    // Show quiz welcome page
    public function welcome()
    {
        return view('quiz-welcome');
    }

    // Show specific question
    public function showQuestion(Request $request, $q = 1)
    {
        $q = (int) $q;

        if ($q > count($this->questions)) {
            // Quiz finished → redirect to finish route
            return redirect()->route('quiz.finish');
        }

        $question = $this->questions[$q - 1];
        $total = count($this->questions);

        return view('quiz', compact('question', 'total', 'q'));
    }

    // Save answer and go to next question
    public function answer(Request $request)
    {
        $q = (int)$request->input('question_number');
        $answer = $request->input('answer');

        // Save answer to session (0-indexed)
        $answers = session()->get('quiz_answers', []);
        $answers[$q - 1] = $answer;
        session(['quiz_answers' => $answers]);

        // Redirect to next question
        $next = $q + 1;
        return redirect()->route('quiz.start', ['q' => $next]);
    }

    // Show quiz finish page
    public function finish()
{
    $questions = $this->questions;
    $answers = session('quiz_answers', []);

    $score = 0;
    $results = [];

    foreach ($questions as $index => $question) {
        $userAnswer = $answers[$index] ?? null;

        // Case-insensitive comparison
        $isCorrect = $userAnswer !== null && strtolower($userAnswer) === strtolower($question['correct']);
        if ($isCorrect) {
            $score++;
        }

        // Save for blade display
        $results[$index] = [
            'title' => $question['title'],
            'correct' => $question['correct'],
            'explanation' => $question['explanation'],
            'userAnswer' => $userAnswer,
            'isCorrect' => $isCorrect,
        ];
    }

    $total = count($questions);

    return view('quiz-finish', [
        'results' => $results,
        'score' => $score,
        'total' => $total,
    ]);
}

}
