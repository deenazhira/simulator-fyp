@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-6xl mx-auto">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#4A0080]">My Performance History</h1>
            <p class="text-gray-500">Track your simulation results and security insights.</p>
        </div>

        <div class="grid gap-6">
            @foreach($results as $result)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row hover:shadow-md transition duration-300">

                {{-- LEFT: SCORE CARD --}}
                <div class="md:w-1/4 bg-gray-50 p-6 flex flex-col justify-center items-center border-r border-gray-100">
                    <div class="text-xs text-gray-400 uppercase font-bold mb-2">Simulation Score</div>

                    {{-- Dynamic Color Logic --}}
                    @php
                        $scoreColor = 'text-red-500';
                        if($result->score >= 80) $scoreColor = 'text-green-500';
                        elseif($result->score >= 50) $scoreColor = 'text-yellow-500';
                    @endphp

                    <div class="text-4xl font-extrabold {{ $scoreColor }}">
                        {{ $result->score }}%
                    </div>
                    <div class="text-sm text-gray-500 mt-2">
                        {{ \Carbon\Carbon::parse($result->quiz_date)->format('M d, Y') }}
                    </div>
                </div>

                {{-- RIGHT: FEEDBACK CONTENT --}}
                <div class="md:w-3/4 p-6 flex flex-col justify-center">

                    {{-- 1. IF TRAINER GAVE FEEDBACK --}}
                    @if($result->feedback_text)
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-bold text-lg text-[#651FFF]">Trainer Feedback</h3>
                                <p class="text-xs text-gray-400">Reviewed by {{ $result->trainer_name }}</p>
                            </div>
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">
                                Reviewed
                            </span>
                        </div>

                        <div class="bg-purple-50 p-4 rounded-xl text-gray-700 text-sm leading-relaxed mb-4">
                            "{{ $result->feedback_text }}"
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-400 uppercase">Recommended Action:</span>
                            <span class="font-semibold text-gray-800">{{ $result->recommended_action }}</span>
                        </div>

                    {{-- 2. IF NO TRAINER (AUTOMATED AI FEEDBACK) --}}
                    @else
                        <div class="mb-3">
                            <span class="bg-cyan-100 text-cyan-700 text-xs font-bold px-3 py-1 rounded-full inline-flex items-center gap-1">
                                <i class="fas fa-robot"></i> Automated Insight
                            </span>
                        </div>

                        {{-- High Score (>= 80) --}}
                        @if($result->score >= 80)
                            <h3 class="font-bold text-green-600 text-lg mb-2">Excellent Security Awareness!</h3>
                            <p class="text-gray-600 text-sm">
                                You successfully identified most threats. You have a strong understanding of phishing indicators. Keep staying vigilant!
                            </p>

                        {{-- Medium Score (50 - 79) --}}
                        @elseif($result->score >= 50)
                            <h3 class="font-bold text-yellow-600 text-lg mb-2">Good Start, But Be Careful.</h3>
                            <p class="text-gray-600 text-sm">
                                You spotted some threats but missed others. Attackers only need one mistake. We recommend trying the
                                <a href="{{ route('quiz.welcome') }}" class="text-[#651FFF] font-bold hover:underline">Simulation</a> again.
                            </p>

                        {{-- Low Score (< 50) --}}
                        @else
                            <h3 class="font-bold text-red-600 text-lg mb-2">High Risk Detected</h3>
                            <p class="text-gray-600 text-sm mb-3">
                                Your score indicates vulnerability to social engineering tactics.
                            </p>
                            <a href="{{ route('awareness') }}" class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg text-sm font-bold inline-block transition">
                                Read Awareness Guide
                            </a>
                        @endif

                    @endif
                </div>

            </div>
            @endforeach

            @if($results->isEmpty())
            <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                <p class="text-gray-400 mb-4">You haven't completed any simulations yet.</p>
                <a href="{{ route('quiz.welcome') }}" class="px-6 py-3 bg-[#651FFF] text-white rounded-full font-bold hover:bg-purple-700 transition">
                    Start Your First Simulation
                </a>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
