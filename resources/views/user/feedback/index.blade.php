@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-6xl mx-auto">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">My Performance & Feedback</h1>
            <p class="text-gray-500">Track your simulation results and advice from your trainer.</p>
        </div>

        <div class="grid gap-6">
            @foreach($results as $result)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">

                <div class="md:w-1/4 bg-gray-50 p-6 flex flex-col justify-center items-center border-r border-gray-100">
                    <div class="text-xs text-gray-400 uppercase font-bold mb-2">Simulation Score</div>
                    <div class="text-4xl font-extrabold {{ $result->score >= 80 ? 'text-green-500' : 'text-red-500' }}">
                        {{ $result->score }}%
                    </div>
                    <div class="text-sm text-gray-500 mt-2">
                        {{ \Carbon\Carbon::parse($result->quiz_date)->format('M d, Y') }}
                    </div>
                </div>

                <div class="md:w-3/4 p-6">
                    @if($result->feedback_text)
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-bold text-lg text-[#651FFF]">Trainer Feedback</h3>
                                <p class="text-xs text-gray-400">Reviewed by {{ $result->trainer_name }} on {{ \Carbon\Carbon::parse($result->feedback_date)->format('d M, h:i A') }}</p>
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
                    @else
                        <div class="h-full flex flex-col justify-center items-start">
                            <h3 class="font-bold text-gray-400 text-lg mb-2">Pending Review</h3>
                            <p class="text-gray-500 text-sm">Your trainer has not reviewed this simulation attempt yet. Check back later.</p>
                        </div>
                    @endif
                </div>

            </div>
            @endforeach

            @if($results->isEmpty())
            <div class="text-center py-12 text-gray-400">
                <p>You haven't completed any simulations yet.</p>
                <a href="{{ route('quiz.welcome') }}" class="text-[#651FFF] font-bold hover:underline mt-2 inline-block">Start a Simulation</a>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
