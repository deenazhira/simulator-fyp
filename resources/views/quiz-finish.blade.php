@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-purple-700 py-16 px-4 text-white">

    <!-- Score & Retry -->
    <div class="max-w-4xl mx-auto text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            You got {{ session('score', 0) }} out of {{ session('total', 10) }} correct
        </h1>
        <p class="mb-6">
            Please click on each of the cards below to see why your answer was correct or incorrect
        </p>
        <a href="{{ route('quiz.welcome') }}" class="inline-block bg-yellow-400 text-purple-800 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition">
            Take quiz again
        </a>
    </div>

    <!-- Grid of question cards -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($questions as $index => $question)
            @php
                $status = $answers[$index+1] ?? null; // answers stored in session
                $correct = $question['correct']; // true/false
                $isCorrect = $status === $correct;
                $borderColor = $status === null ? 'border-gray-400' : ($isCorrect ? 'border-green-500' : 'border-red-500');
            @endphp

            <div class="bg-white rounded-lg shadow-md p-4 border-4 {{ $borderColor }} cursor-pointer hover:shadow-lg transition">
                <h3 class="font-semibold text-gray-800 mb-2 text-sm sm:text-base">
                    {{ $question['title'] }}
                </h3>
                @if($status !== null)
                    <p class="text-gray-600 text-xs sm:text-sm">
                        {{ $question['explanation'] }}
                    </p>
                @else
                    <p class="text-gray-400 text-xs sm:text-sm">Not answered</p>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
