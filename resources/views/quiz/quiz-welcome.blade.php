@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-[#4A0080] text-center px-4">

    <!-- Title -->
    <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-8">
        Simulation Quiz
    </h1>

    <!-- Description -->
    <p class="text-white text-lg md:text-xl mb-12 max-w-2xl leading-relaxed">
        Test your ability to spot social engineering tricks. Each question shows a realistic scenario — can you tell what’s safe and what’s suspicious?
    </p>

    <!-- Start Quiz Button -->
    <a href="{{ route('quiz.start') }}"
       class="bg-yellow-400 hover:bg-yellow-300 text-purple-800 font-bold px-10 py-4 rounded-full text-xl shadow-lg transition transform hover:scale-105">
        Start Quiz
    </a>

</div>
@endsection
