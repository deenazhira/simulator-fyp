@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#4A0080] flex flex-col items-center justify-center py-12">

    {{-- Back button --}}
    <a href="{{ route('quiz.finish') }}"
       class="mb-6 inline-flex items-center text-purple-700 hover:text-purple-900 transition">
        ← Back to Results
    </a>

    {{-- Card container --}}
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-4xl relative">
        <h2 class="text-2xl font-bold text-purple-800 mb-4">
            {{ $question['title'] }}
        </h2>

        {{-- Result badge --}}
        <div class="mb-4">
            @if ($question['userAnswer'] === $question['correct'])
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Correct</span>
            @else
                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">Incorrect</span>
            @endif
        </div>

        {{-- Image section with overlay --}}
        <div class="relative border rounded-xl overflow-hidden shadow">
            <img src="{{ asset($question['image']) }}" alt="Question Image" class="w-full object-cover">

            {{-- "Phishing!" overlay text --}}
            <div class="absolute top-4 left-4 bg-red-600 text-white px-4 py-2 rounded-lg text-lg font-bold shadow-lg">
                {{ $question['correct'] === 'Phishing' ? 'Phishing!' : 'Legitimate' }}
            </div>

            {{-- Red speech bubbles (annotations) --}}
            @foreach ($annotations as $a)
                <div class="absolute border-2 border-red-500 bg-red-100/80 text-red-800 text-sm px-2 py-1 rounded-lg"
                     style="top: {{ $a['y'] }}%; left: {{ $a['x'] }}%; width: {{ $a['w'] }}%; height: {{ $a['h'] }}%;">
                    💬 {{ $a['label'] }}
                </div>
            @endforeach
        </div>

        {{-- Explanation box --}}
        <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-gray-800 leading-relaxed">
                <strong>Explanation:</strong> {{ $question['explanation'] }}
            </p>
        </div>

        {{-- Navigation buttons --}}
        <div class="mt-8 flex justify-between">
            @if ($index > 0)
                <a href="{{ route('quiz.result', ['id' => $index - 1]) }}"
                   class="bg-purple-100 text-purple-700 px-4 py-2 rounded-lg font-semibold hover:bg-purple-200 transition">
                   ← Previous
                </a>
            @else
                <div></div>
            @endif

            @if ($index < 9)
                <a href="{{ route('quiz.result', ['id' => $index + 1]) }}"
                   class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition">
                   Next →
                </a>
            @else
                <a href="{{ route('quiz.finish') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                   Back to Results
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
