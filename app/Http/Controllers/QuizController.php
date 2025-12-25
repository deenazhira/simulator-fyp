<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   // ✅ Added for Database
use Illuminate\Support\Facades\Auth; // ✅ Added for Auth Check

class QuizController extends Controller
{
    // ===============================
    // QUIZ QUESTIONS
    // ===============================
    private $questions = [
        [
            'title' => 'Is this email phishing or legitimate?',
            'image' => 'images/quiz/phis-s1.png',
            'correct' => 'Phishing',
            'explanation' => 'This is a classic phishing attempt with a suspicious sender and link.'
        ],
        [
            'title' => 'This social media message link looks suspicious. Phishing or Legit?',
            'image' => 'images/quiz/phis-s2.png',
            'correct' => 'Phishing',
            'explanation' => 'Shortened or disguised links can lead to phishing pages.'
        ],
        [
            'title' => 'You received a message claiming you won a prize. Is it phishing?',
            'image' => 'images/quiz/legit-s3.png',
            'correct' => 'Phishing',
            'explanation' => 'Unexpected prize emails are common phishing traps.'
        ],
        [
            'title' => 'An email asks for your password to verify your account. Phishing or Legit?',
            'image' => 'images/quiz/legit-s4.png',
            'correct' => 'Phishing',
            'explanation' => 'Legitimate services never request passwords via email.'
        ],
        [
            'title' => 'A colleague sends a strange attachment unexpectedly. Safe or Suspicious?',
            'image' => 'images/quiz/phis-s5.png',
            'correct' => 'Phishing',
            'explanation' => 'Unexpected attachments may contain malware.'
        ],
        [
            'title' => 'A website asks you to login via a link sent in chat. Phishing or Legit?',
            'image' => 'images/quiz/phis-s6.png',
            'correct' => 'Phishing',
            'explanation' => 'Always type URLs manually; chat links can be fake.'
        ],
        [
            'title' => 'You receive an urgent email from “IT support” asking for credentials. Safe?',
            'image' => 'images/quiz/phis-s7.png',
            'correct' => 'Phishing',
            'explanation' => 'IT departments never ask for login details via email.'
        ],
        [
            'title' => 'A notification claims you need to reset your password now. Phishing or Legit?',
            'image' => 'images/quiz/phis-s8.png',
            'correct' => 'Phishing',
            'explanation' => 'Urgent tone creates panic — a classic phishing sign.'
        ],
        [
            'title' => 'A random email asks to verify payment details. Safe or Suspicious?',
            'image' => 'images/quiz/phis-s9.png',
            'correct' => 'Phishing',
            'explanation' => 'Never share payment info through random emails.'
        ],
        [
            'title' => 'You get a message from an unknown sender with a link. Phishing or Legit?',
            'image' => 'images/quiz/legit-s10.png',
            'correct' => 'Phishing',
            'explanation' => 'Unknown senders with links are always suspicious.'
        ],
    ];

    // ===============================
    // QUIZ START PAGE
    // ===============================
    public function welcome()
    {
        // Optional: Clear session on welcome to start fresh
        session()->forget(['quiz_answers', 'quiz_results']);
        return view('quiz/quiz-welcome');
    }

    // ===============================
    // SHOW ONE QUESTION
    // ===============================
    public function showQuestion(Request $request, $q = 1)
    {
        $q = (int) $q;

        if ($q > count($this->questions)) {
            return redirect()->route('quiz.finish');
        }

        $question = $this->questions[$q - 1];
        $total = count($this->questions);

        return view('quiz/quiz', compact('question', 'total', 'q'));
    }

    // ===============================
    // SAVE ANSWER
    // ===============================
    public function answer(Request $request)
    {
        $q = (int)$request->input('question_number');
        $answer = $request->input('answer');

        $answers = session()->get('quiz_answers', []);
        $answers[$q - 1] = $answer;
        session(['quiz_answers' => $answers]);

        $next = $q + 1;
        return redirect()->route('quiz.start', ['q' => $next]);
    }

    // ===============================
    // FINISH PAGE (UPDATED WITH DB SAVE)
    // ===============================
    public function finish()
    {
        $questions = $this->questions;
        $answers = session('quiz_answers', []);

        $score = 0;
        $results = [];

        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? null;

            $isCorrect = $userAnswer !== null && strtolower($userAnswer) === strtolower($question['correct']);
            if ($isCorrect) $score++;

            $results[$index] = [
                'title' => $question['title'],
                'image' => $question['image'],
                'correct' => $question['correct'],
                'explanation' => $question['explanation'],
                'userAnswer' => $userAnswer,
                'isCorrect' => $isCorrect,
            ];
        }

        session(['quiz_results' => $results]); // store results for feedback view

        $total = count($questions);

        // ✅ NEW: CALCULATE PERCENTAGE & SAVE TO DATABASE
        // This ensures the Trainer Dashboard gets the data
        if (Auth::check()) {
            $percentage = ($total > 0) ? round(($score / $total) * 100) : 0;

            DB::table('quiz_results')->insert([
                'user_id' => Auth::user()->user_id, // Matches your custom user_id
                'score' => $percentage,
                'total_questions' => $total,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('quiz/quiz-finish', [
            'results' => $results,
            'score' => $score,
            'total' => $total,
        ]);
    }

    // ===============================
    // INDIVIDUAL FEEDBACK PAGE
    // ===============================
    public function showResult($id)
    {
        $index = (int)$id;
        $results = session('quiz_results', []);

        if (!isset($results[$index])) {
            abort(404);
        }

        $question = $results[$index];

        // Optional: image annotations or highlighted zones
        $annotationsPerQuestion = [
            0 => [
                ['x'=>12, 'y'=>14, 'w'=>40, 'h'=>18, 'label'=>'Suspicious sender'],
                ['x'=>55, 'y'=>60, 'w'=>30, 'h'=>15, 'label'=>'Fake link'],
            ],
            1 => [
                ['x'=>20, 'y'=>35, 'w'=>50, 'h'=>20, 'label'=>'Hidden URL'],
            ],
            // You can add more annotations for other questions here if needed
        ];

        $annotations = $annotationsPerQuestion[$index] ?? [];

        return view('quiz/quiz-result', [
            'index' => $index,
            'question' => $question,
            'annotations' => $annotations,
        ]);
    }
}

