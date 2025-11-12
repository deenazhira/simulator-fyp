@extends('layouts.app')

@section('content')
<div class="container mx-auto py-20 text-center">
    <h1 class="text-4xl font-bold text-purple-800 mb-6">Simulation Quiz</h1>
    <p class="text-gray-700 mb-10 max-w-xl mx-auto leading-relaxed">
        Test your ability to spot social engineering tricks. Each question shows a realistic scenario — can you tell what’s safe and what’s suspicious?
    </p>
    <a href="{{ route('quiz.start') }}" class="bg-purple-600 text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-purple-700 transition">
        Start Quiz
    </a>
</div>
@endsection
