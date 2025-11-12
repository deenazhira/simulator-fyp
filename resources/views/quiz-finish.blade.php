@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-purple-700 py-16 px-4 text-white">

    <!-- Score & Retry -->
    <div class="max-w-4xl mx-auto text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            You got {{ $score }} out of {{ $total }} correct
        </h1>
        <p class="mb-6">
            Click on each card to see why your answer was correct or incorrect
        </p>
        <a href="{{ route('quiz.welcome') }}" class="inline-block bg-yellow-400 text-purple-800 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition">
            Take quiz again
        </a>
    </div>

    <!-- Grid of question cards -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($results as $result)
            @php
                $borderColor = $result['userAnswer'] === null
                               ? 'border-gray-400'
                               : ($result['isCorrect'] ? 'border-green-500' : 'border-red-500');
            @endphp

            <div class="bg-white rounded-lg shadow-md p-4 border-4 {{ $borderColor }} cursor-pointer hover:shadow-lg transition">
                <h3 class="font-semibold text-gray-800 mb-2 text-sm sm:text-base">
                    {{ $result['title'] }}
                </h3>
                @if($result['userAnswer'] !== null)
                    <p class="text-gray-600 text-xs sm:text-sm">
                        Your answer: {{ $result['userAnswer'] }} <br>
                        Correct answer: {{ $result['correct'] }} <br>
                        Explanation: {{ $result['explanation'] }}
                    </p>
                @else
                    <p class="text-gray-400 text-xs sm:text-sm">Not answered</p>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
