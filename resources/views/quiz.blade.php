@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-4 text-center">Phishing Or Legitimate?</h1>

    <div class="flex justify-center gap-2 mb-6">
        @for($i = 1; $i <= $total; $i++)
            <div class="w-10 h-10 rounded-full flex items-center justify-center border @if($i == $q) bg-purple-700 text-white @else bg-gray-200 @endif">
                {{ $i }}
            </div>
        @endfor
    </div>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">{{ $question['title'] }}</h2>

        <form id="quizForm" method="POST" action="{{ route('phish.quiz.answer') }}">
            @csrf
            <input type="hidden" name="question_number" value="{{ $q }}">
            <input type="hidden" name="answer" id="answerInput" value="">

            <!-- image of email/screenshot -->
            <div class="mb-4">
                <img src="{{ asset($question['image']) }}" alt="question image" class="w-full border rounded">
            </div>

            <div class="flex gap-4 justify-center mb-4">
                <button type="button" id="phishingBtn" class="btn-answer px-6 py-2 rounded bg-red-600 text-white">Phishing</button>
                <button type="button" id="legitBtn" class="btn-answer px-6 py-2 rounded bg-green-600 text-white">Legitimate</button>
            </div>

            <div class="text-center">
                <button id="nextBtn" type="submit" disabled class="px-6 py-2 rounded bg-blue-500 text-white opacity-60 cursor-not-allowed">Next</button>
            </div>
        </form>
    </div>

    @if(session('message'))
        <div class="mt-4 text-center text-green-600">{{ session('message') }}</div>
    @endif
</div>

<!-- Inline JS: keep it simple -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const phishingBtn = document.getElementById('phishingBtn');
    const legitBtn = document.getElementById('legitBtn');
    const nextBtn = document.getElementById('nextBtn');
    const answerInput = document.getElementById('answerInput');

    function selectAnswer(value, btn) {
        // set hidden value
        answerInput.value = value;
        // enable Next
        nextBtn.disabled = false;
        nextBtn.classList.remove('opacity-60', 'cursor-not-allowed');
        // highlight
        document.querySelectorAll('.btn-answer').forEach(b => b.classList.remove('ring-4','ring-offset-2'));
        btn.classList.add('ring-4','ring-offset-2');
    }

    phishingBtn.addEventListener('click', function () {
        selectAnswer('Phishing', phishingBtn);
    });

    legitBtn.addEventListener('click', function () {
        selectAnswer('Legitimate', legitBtn);
    });

    // extra guard: prevent submit if answer empty (in case of manual submit)
    document.getElementById('quizForm').addEventListener('submit', function (e) {
        if (!answerInput.value) {
            e.preventDefault();
            alert('Please choose Phishing or Legitimate before moving on.');
        }
    });
});
</script>

<style>
/* small visual helpers; add Tailwind or your own CSS */
.ring-4 { box-shadow: 0 0 0 4px rgba(99,102,241,0.2); }
.ring-offset-2 { margin: 2px; }
</style>
@endsection
