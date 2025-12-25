@extends('layouts.app')

@section('content')
{{--
    Main Container:
    - h-screen: Forces full screen height.
    - overflow-hidden: No scrollbars.
    - justify-between: Pushes content to top and bottom edges.
--}}
<div class="h-screen flex flex-col justify-between items-center bg-[#4A0080] text-center px-4 py-8 overflow-hidden">

    {{-- Top Content Wrapper --}}
    <div class="flex-shrink-0 mt-8">
        <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
            Simulation Quiz
        </h1>

        <p class="text-white text-lg md:text-xl mb-10 max-w-3xl mx-auto leading-relaxed font-light">
            Test your ability to spot social engineering tricks. Each question shows a realistic scenario — can you tell what’s safe and what’s suspicious?
        </p>

        {{--
             ✅ CHANGE: Changed 'rounded-lg' to 'rounded-md'.
             This matches the shape in the reference image but keeps your yellow color.
        --}}
        <!-- Start Quiz Button -->

        <a href="{{ route('quiz.start') }}"
            class="bg-yellow-400 hover:bg-yellow-300 text-purple-800 font-bold px-10 py-4 rounded-full text-xl shadow-lg transition transform hover:scale-105">
            Start Quiz
        </a>
    </div>

    {{-- Image Container (Flex Grow to fill remaining space) --}}
    <div class="flex-grow w-full flex items-center justify-center py-4 overflow-hidden">
        <img src="{{ asset('images/quiz-illustration.png') }}"
             alt="Quiz Simulation Illustration"
             class="max-w-full max-h-full object-contain drop-shadow-2xl">
    </div>

</div>
@endsection

