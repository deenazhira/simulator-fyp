@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-3xl">

    <h1 class="text-3xl font-bold mb-4 text-center text-purple-800">Phishing or Legitimate?</h1>

    <!-- Progress -->
    <div class="flex justify-center gap-2 mb-6">
        @for($i = 1; $i <= $total; $i++)
            <div class="w-10 h-10 rounded-full flex items-center justify-center border @if($i == $q) bg-purple-700 text-white @else bg-gray-200 @endif">
                {{ $i }}
            </div>
        @endfor
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <!-- Answer Buttons Above Image -->
        <form id="quizForm" method="POST" action="{{ route('phish.quiz.answer') }}">
            @csrf
            <input type="hidden" name="question_number" value="{{ $q }}">
            <input type="hidden" name="answer" id="answerInput" value="">

            <div class="flex gap-4 justify-center mb-4">
                <button type="button" id="phishingBtn" class="btn-answer px-6 py-2 rounded bg-red-600 text-white">Phishing</button>
                <button type="button" id="legitBtn" class="btn-answer px-6 py-2 rounded bg-green-600 text-white">Legitimate</button>
            </div>

            <!-- Image -->
            <div class="mb-4">
                <img src="{{ asset($question['image']) }}" alt="question image" class="w-full border rounded">
            </div>

            <h2 class="text-xl font-semibold text-center">{{ $question['title'] }}</h2>
        </form>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const phishingBtn = document.getElementById('phishingBtn');
    const legitBtn = document.getElementById('legitBtn');
    const answerInput = document.getElementById('answerInput');
    const form = document.getElementById('quizForm');

    function submitAnswer(value) {
        answerInput.value = value;
        form.submit();
    }

    phishingBtn.addEventListener('click', function () {
        submitAnswer('Phishing');
    });

    legitBtn.addEventListener('click', function () {
        submitAnswer('Legitimate');
    });
});
</script>
@endsection
