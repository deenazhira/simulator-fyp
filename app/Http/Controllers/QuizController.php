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
    private $set1 = [
        [
            'title' => 'You receive an email from "Coca-Cola" claiming you won a free blender. Is this legitimate?',
            'image' => 'images/quiz/phis-s1.png',
            'result_image' => 'images/quiz/sol-s1.png',
            'correct' => 'Phishing',
            'explanation' => 'Check the sender address closely. The display name says "Coca-Cola",
                              but the email address is a random string of characters (`@cpmedj.georg.fsdh.com`)
                              instead of the official `@coca-cola.com`. This is a clear sign of impersonation.',
        ],
        [
            'title' => 'Your CEO calls you on Zoom/Teams, but their video glitches when they turn their head.',
            'image' => 'images/quiz/phis-s2.png',
            'result_image' => 'images/quiz/sol-s2.png',
            'correct' => 'Phishing',
            'explanation' => 'Deepfake AI video attacks are rising. Unnatural blurring or glitching
                              around the face/neck is a key sign of a deepfake.'
        ],
        [
            'title' => 'You receive a reminder email about mandatory cybersecurity training. Is this safe?',
            'image' => 'images/quiz/legit-s3.png',
            'result_image' => 'images/quiz/sol-s3.png',
            'correct' => 'Legitimate',
            'explanation' => 'This is a standard internal communication. The sender address appears professional,
                              the request (mandatory training) is a normal business activity, and the
                              tone is helpful rather than panic alert.'
        ],
        [
            'title' => 'You log in to the company portal and receive a 6-digit code on your phone that you requested.',
            'image' => 'images/quiz/legit-s4.png',
            'result_image' => 'images/quiz/sol-s4.png',
            'correct' => 'Legitimate',
            'explanation' => 'This is standard Multi-Factor Authentication (MFA).
                              Since You initiated the login, the code is expected and safe.'
        ],
        [
            'title' => 'An ad for "ChatGPT-4 Premium Free" asks you to download a Chrome Extension.',
            'image' => 'images/quiz/phis-s5.png',
            'result_image' => 'images/quiz/sol-s5.png',
            'correct' => 'Phishing',
            'explanation' => 'Fake AI tools are a top trend. They often install "stealer malware"
                              to hijack your browser cookies and passwords.'
        ],
        [
            'title' => 'You are added to a Telegram group called "Syariah Gold Investment". The admin posts proof of 200% returns in just 3 hours.',
            'image' => 'images/quiz/phis-s6.png',
            'result_image' => 'images/quiz/sol-s6.png',
            'correct' => 'Phishing',
            'explanation' => 'Investment on Telegram are totally scam. Any scheme promising huge
                              returns (200%) in a short time is a scam.'
        ],
        [
            'title' => 'A "Microsoft Support" window freezes your browser and says "Do not close. Call this number".',
            'image' => 'images/quiz/phis-s7.png',
            'result_image' => 'images/quiz/sol-s7.png',
            'correct' => 'Phishing',
            'explanation' => 'This is a "Tech Support Scam". No legitimate error message will ever
                              ask you to call a phone number.'
        ],
        [
            'title' => 'An email claiming to be from "HR" asks you to scan a QR code to view your new salary slip.',
            'image' => 'images/quiz/phis-s8.png',
            'result_image' => 'images/quiz/sol-s8.png',
            'correct' => 'Phishing',
            'explanation' =>  ' Attackers use QR codes in emails to bypass traditional email
                                scanners that only look for malicious text links.'
        ],
        [
            'title' => 'Someone send wedding invitation through WhatsApp. To view, they ask you to download an apk file "Jemputan Majlis Perkahwinan" via WhatsApp.',
            'image' => 'images/quiz/phis-s9.png',
            'result_image' => 'images/quiz/sol-s9.png',
            'correct' => 'Phishing',
            'explanation' => 'The "APK Scam" is huge in worldwide. Installing unknown .apk files allows
                              hackers to steal your SMS TAC numbers and drain your bank account.'
        ],
        [
            'title' =>  'You receive an SMS from "MKN" (Majlis Keselamatan Negara) with a general public service announcement about dengue prevention.',
            'image' => 'images/quiz/legit-s10.png',
            'result_image' => 'images/quiz/sol-s10.png',
            'correct' => 'Legitimate',
            'explanation' => 'The Malaysian government (MKN) sends legitimate SMS blasts for public awareness.
                              They typically do not contain clickable links.'
        ],
    ];

    private $set2 = [
        [
            'title' => 'You receive a text asking you to "CANCEL" a password reset by replying with your verification code. Is this safe?',
            'image' => 'images/quiz/phis-s11.png',
            'result_image' => 'images/quiz/sol-s11.png',
            'correct' => 'Phishing',
            'explanation' => 'Legitimate services (like Google or banks) will NEVER ask you to text
                              them your verification code to cancel a request. The attacker is trying
                              to trick you into forwarding the code so they can bypass your Two-Factor Authentication.',
        ],
        [
            'title' => 'You see a social media ad offering luxury bags at 80% off. Is this a legitimate deal?',
            'image' => 'images/quiz/phis-s12.png',
            'result_image' => 'images/quiz/sol-s12.png',
            'correct' => 'Phishing',
            'explanation' => 'This is a "Fake Shop" scam. The domain (store-malaysia.click) is not the
                              official brand site, and the prices (RM 200 for a luxury bag) are "too good to be true."
                              legitimate luxury brands do not use cheap domains like .click or .xyz.'
        ],
        [
            'title' => 'You receive a reply to an ongoing project thread with an invoice attached. Is this safe?',
            'image' => 'images/quiz/legit-s13.png',
            'result_image' => 'images/quiz/sol-s13.png',
            'correct' => 'Legitimate',
            'explanation' => 'Context is key. Because this email is a "Reply" (Re:) to a conversation you are
                              already having, and the attachment (PDF invoice) matches the project discussion,
                              it is safe. Phishing emails rarely have genuine thread history.'
        ],
        [
            'title' => 'It\'s the first of the month. You receive an automated email receipt from Netflix for your standard monthly subscription fee.',
            'image' => 'images/quiz/legit-s14.png',
            'result_image' => 'images/quiz/sol-s14.png',
            'correct' => 'Legitimate',
            'explanation' => 'Routine, expected emails for services you subscribe to are normal.
                              Always verify the sender domain matches the service.'
        ],
        [
            'title' => 'You find a parking ticket on your car with a QR code to "Pay Fine Online".',
            'image' => 'images/quiz/phis-s15.png',
            'result_image' => 'images/quiz/sol-s15.png',
            'correct' => 'Phishing',
            'explanation' => 'This is "Quishing" (QR Phishing). Scammers stick fake QR codes over
                              real meters or tickets to steal payment info.'
        ],
        [
            'title' => 'You receive an email from "PayPaI" (with a capital "i") saying your account is suspended.',
            'image' => 'images/quiz/phis-s16.png',
            'result_image' => 'images/quiz/sol-s16.png',
            'correct' => 'Phishing',
            'explanation' =>  'Look closely at the sender name. Typosquatting
                               (PayPaI vs PayPal) is a common trick.'
        ],
        [
            'title' =>  'The IT Department sends a company-wide email announcing scheduled maintenance this weekend. No links are attached.',
            'image' => 'images/quiz/legit-s17.png',
            'result_image' => 'images/quiz/sol-s17.png',
            'correct' => 'Legitimate',
            'explanation' => 'Informational emails from verified internal addresses that do not ask
                              for action or login are usually safe.'
        ],
        [
            'title' => 'You try to transfer funds on Maybank2u. Instead of an SMS TAC, you receive a "Secure2u" push notification on your MAE app asking to "Approve".',
            'image' => 'images/quiz/legit-s18.png',
            'result_image' => 'images/quiz/sol-s18.png',
            'correct' => 'Legitimate',
            'explanation' =>  'Major Malaysian banks (Maybank, CIMB) have replaced SMS TAC with
                               App Authorization (Secure2u) for better security.'
        ],
        [
            'title' => 'You receive an SMS claiming "Bantuan Tunai Rahmah (STR) approved. Click bit.ly/claim-str-now to credit RM100 to your account."',
            'image' => 'images/quiz/phis-s19.png',
            'result_image' => 'images/quiz/sol-s19.png',
            'correct' => 'Phishing',
            'explanation' => 'Government aid (STR/e-Madani) is never claimed via Bit.ly links in SMS.
                              It is automatically credited or claimed in official apps.'
        ],
        [
            'title' =>  'You receive a job offer for "Data Entry" that requires you to chat only via Telegram/Signal.',
            'image' => 'images/quiz/phis-s20.png',
            'result_image' => 'images/quiz/sol-s20.png',
            'correct' => 'Phishing',
            'explanation' =>'Scammers move you to encrypted apps Telegram to avoid
                             detection by email security filters.'
        ],
    ];

    // ===============================
    // QUIZ START PAGE
    // ===============================
    public function welcome()
    {
        // 1. Clear previous sessions INCLUDING the 'saved' flag
        session()->forget(['quiz_answers', 'quiz_results', 'current_quiz_set', 'quiz_saved']);

        // 2. Randomly pick Set 1 or Set 2
        $selectedSet = (random_int(0, 1) === 0) ? $this->set1 : $this->set2;

        // 3. Store the chosen set in Session
        session(['current_quiz_set' => $selectedSet]);

        return view('quiz/quiz-welcome');
    }

    // ===============================
    // SHOW ONE QUESTION
    // ===============================
    public function showQuestion(Request $request, $q = 1)
    {
        // ✅ Retrieve the questions from the session
        $questions = session('current_quiz_set');

        // Safety check: If session expired, restart
        if (!$questions) {
            return redirect()->route('quiz.welcome');
        }

        $q = (int) $q;

        if ($q > count($questions)) {
            return redirect()->route('quiz.finish');
        }

        $question = $questions[$q - 1];
        $total = count($questions);

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
        // 1. Get the questions specifically used for this session
        $questions = session('current_quiz_set');

        if (!$questions) {
            return redirect()->route('quiz.welcome');
        }

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
                'result_image' => $question['result_image'] ?? null,
                'correct' => $question['correct'],
                'explanation' => $question['explanation'],
                'userAnswer' => $userAnswer,
                'isCorrect' => $isCorrect,
            ];
        }

        session(['quiz_results' => $results]);

        $total = count($questions);

        // ==================================================
        // ✅ FIX: PREVENT DUPLICATE SAVES ON REFRESH
        // ==================================================
        if (Auth::check() && !session()->has('quiz_saved')) {
            $percentage = ($total > 0) ? round(($score / $total) * 100) : 0;

            DB::table('quiz_results')->insert([
                'user_id' => Auth::user()->user_id,
                'score' => $percentage,
                'total_questions' => $total,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Mark this session as "Saved" so it doesn't happen again if they refresh
            session(['quiz_saved' => true]);
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


        $annotations = [];

        return view('quiz/quiz-result', [
            'index' => $index,
            'question' => $question,
            'annotations' => $annotations,
        ]);
    }
}

