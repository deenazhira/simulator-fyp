@extends('layouts.app')

@section('content')
<div class="container mx-auto pb-8 mt-6 px-4">

    <div class="bg-[#4A0080] text-white p-10 text-center shadow-xl rounded-t-3xl">

        <h1 class="text-4xl md:text-3xl font-extrabold mb-4 tracking-wide text-white opacity-100 uppercase">
        Phishing Or Legitimate
    </h1>

    <h2 class="text-xl md:text-2xl font-bold text-white mb-6 leading-relaxed">
        {{ $question['title'] }}
    </h2>


        <div class="flex flex-wrap justify-center gap-3 mb-8">
            @for($i = 1; $i <= $total; $i++)
                <div class="w-11 h-11 rounded-full flex items-center justify-center text-sm transition-all duration-300 shadow-sm
                            @if($i == $q) bg-white text-[#4A0080] font-extrabold scale-110 ring-4 ring-purple-400/50 @else bg-[#6A2C9E] text-white hover:bg-[#7e3bbb] @endif">
                    {{ $i }}
                </div>
            @endfor
        </div>

        <div class="flex gap-6 justify-center">
            <button type="button" id="phishingBtn"
                class="btn-answer px-10 py-3 rounded-full bg-red-500 hover:bg-red-600 font-bold text-lg text-white transition transform hover:scale-105 shadow-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                Phishing
            </button>
            <button type="button" id="legitBtn"
                class="btn-answer px-10 py-3 rounded-full bg-green-500 hover:bg-green-600 font-bold text-lg text-white transition transform hover:scale-105 shadow-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Legitimate
            </button>
        </div>

    </div>

    <div class="bg-white p-8 rounded-b-3xl shadow-xl border-t-0">
        <div class="max-w-4xl mx-auto shadow-lg rounded-lg overflow-hidden border border-gray-100">
            <img src="{{ asset($question['image']) }}" alt="question image" class="w-full h-auto object-cover">
        </div>
    </div>

</div>

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

