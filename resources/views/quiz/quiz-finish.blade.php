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
    @foreach($results as $index => $result)
        @php
            $borderColor = $result['userAnswer'] === null
                ? 'border-gray-400'
                : ($result['isCorrect'] ? 'border-green-500' : 'border-red-500');
        @endphp

        <a href="{{ route('quiz.result', ['id' => $index]) }}" class="block hover:scale-105 transition transform">
    <div class="border-4 rounded-xl p-4 shadow bg-white {{ $result['isCorrect'] ? 'border-green-400' : 'border-red-400' }}">
        <img src="{{ asset($result['image']) }}" class="rounded-lg mb-3">
        <h3 class="font-semibold text-purple-800">{{ $result['title'] }}</h3>
        <p class="text-sm text-gray-600">
            {{ $result['isCorrect'] ? 'Correct' : 'Incorrect' }}
        </p>
    </div>
</a>

    @endforeach
</div>

</div>
@endsection
