@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">

    <!-- Top section: title, question numbers, buttons -->
    <div class="bg-purple-700 text-white rounded-t-xl p-8 text-center shadow-md">

        <!-- Title -->
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Phishing Or Legitimate?</h1>

        <!-- Description -->
        <p class="mb-6 max-w-2xl mx-auto leading-relaxed">
            Test your ability to spot social engineering tricks. Each question shows a realistic scenario — can you tell what’s safe and what’s suspicious?
        </p>

        <!-- Question Numbers -->
        <div class="flex justify-center gap-2 mb-6">
            @for($i = 1; $i <= $total; $i++)
                <div class="w-10 h-10 rounded-full flex items-center justify-center
                            @if($i == $q) bg-white text-purple-700 font-bold @else bg-purple-500 text-white @endif">
                    {{ $i }}
                </div>
            @endfor
        </div>

        <!-- Answer Buttons -->
        <div class="flex gap-4 justify-center">
            <button type="button" id="phishingBtn" class="btn-answer px-6 py-2 rounded bg-red-500 hover:bg-red-600 font-semibold transition">
                Phishing
            </button>
            <button type="button" id="legitBtn" class="btn-answer px-6 py-2 rounded bg-green-500 hover:bg-green-600 font-semibold transition">
                Legitimate
            </button>
        </div>

    </div>

    <!-- Image Section -->
    <div class="bg-white p-6 rounded-b-xl shadow-md mt-0">
        <div class="max-w-3xl mx-auto">
            <img src="{{ asset($question['image']) }}" alt="question image" class="w-full border rounded">
        </div>
    </div>

</div>

<!-- Auto-submit JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const phishingBtn = document.getElementById('phishingBtn');
    const legitBtn = document.getElementById('legitBtn');

    function submitAnswer(value) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('phish.quiz.answer') }}";

        // CSRF token
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = "{{ csrf_token() }}";
        form.appendChild(token);

        // Question number
        const questionNumber = document.createElement('input');
        questionNumber.type = 'hidden';
        questionNumber.name = 'question_number';
        questionNumber.value = "{{ $q }}";
        form.appendChild(questionNumber);

        // Answer
        const answerInput = document.createElement('input');
        answerInput.type = 'hidden';
        answerInput.name = 'answer';
        answerInput.value = value;
        form.appendChild(answerInput);

        document.body.appendChild(form);
        form.submit();
    }

    phishingBtn.addEventListener('click', function () { submitAnswer('Phishing'); });
    legitBtn.addEventListener('click', function () { submitAnswer('Legitimate'); });
});
</script>
@endsection
