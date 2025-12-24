@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8 flex justify-center items-start pt-12">

    <div class="w-full max-w-5xl bg-[#651FFF] rounded-3xl shadow-2xl overflow-hidden relative">

        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full transform translate-x-20 -translate-y-20"></div>

        <form action="{{ route('trainer.feedback.store') }}" method="POST">
            @csrf
            <input type="hidden" name="quiz_result_id" value="{{ $quizResult->id }}">
            <input type="hidden" name="user_id" value="{{ $user->user_id }}">

            <div class="p-8 text-center text-white">
                <h1 class="text-3xl font-bold mb-6">Trainer Feedback</h1>

                <div class="flex justify-center gap-4 mb-8">
                    <div class="bg-white/10 px-6 py-2 rounded-xl backdrop-blur-sm">
                        <div class="text-xs text-purple-200 uppercase">Staff Name</div>
                        <div class="font-bold text-lg">{{ $user->user_name }}</div>
                    </div>
                    <div class="bg-white/10 px-6 py-2 rounded-xl backdrop-blur-sm">
                        <div class="text-xs text-purple-200 uppercase">Staff ID</div>
                        <div class="font-bold text-lg">STF{{ str_pad($user->user_id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="bg-white/10 px-6 py-2 rounded-xl backdrop-blur-sm">
                        <div class="text-xs text-purple-200 uppercase">Department</div>
                        <div class="font-bold text-lg">{{ $user->company_name ?? 'Cybersecurity' }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl text-gray-800 p-4 grid grid-cols-5 gap-4 items-center mb-8 shadow-lg">
                    <div class="text-left pl-4">
                        <div class="text-xs text-gray-400 uppercase font-bold">Simulation ID</div>
                        <div class="font-bold">SIM-{{ $quizResult->id }}</div>
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-gray-400 uppercase font-bold">Date</div>
                        <div class="font-semibold">{{ \Carbon\Carbon::parse($quizResult->created_at)->format('d-m-Y') }}</div>
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-gray-400 uppercase font-bold">Time</div>
                        <div class="font-semibold">{{ \Carbon\Carbon::parse($quizResult->created_at)->format('H:i A') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-400 uppercase font-bold">Score</div>
                        <div class="font-bold">{{ $quizResult->score }}%</div>
                    </div>
                    <div class="text-right pr-4">
                        @if($quizResult->score >= 80)
                            <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full font-bold text-sm border border-green-200">PASS</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-4 py-1 rounded-full font-bold text-sm border border-red-200">FAIL</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">

                    <div class="md:col-span-2">
                        <label class="block text-purple-100 font-semibold mb-2">Detailed Feedback</label>
                        <textarea name="feedback_text" rows="8"
                            class="w-full rounded-2xl p-4 text-gray-800 focus:ring-4 focus:ring-purple-400 border-none shadow-inner"
                            placeholder="Write your observation and advice here..." required></textarea>
                    </div>

                    <div>
                        <label class="block text-purple-100 font-semibold mb-2">Recommended Next Step</label>
                        <div class="bg-white rounded-2xl p-4 space-y-3 shadow-inner">
                            <label class="flex items-center space-x-3 p-3 rounded-xl hover:bg-purple-50 cursor-pointer transition">
                                <input type="radio" name="recommended_action" value="Reattempt Simulation" class="text-[#651FFF] focus:ring-[#651FFF]" required>
                                <span class="text-gray-700 font-medium">Reattempt Simulation</span>
                            </label>

                            <label class="flex items-center space-x-3 p-3 rounded-xl hover:bg-purple-50 cursor-pointer transition">
                                <input type="radio" name="recommended_action" value="One-on-One Session" class="text-[#651FFF] focus:ring-[#651FFF]">
                                <span class="text-gray-700 font-medium">Schedule 1-on-1</span>
                            </label>

                            <label class="flex items-center space-x-3 p-3 rounded-xl hover:bg-purple-50 cursor-pointer transition">
                                <input type="radio" name="recommended_action" value="No Further Action" class="text-[#651FFF] focus:ring-[#651FFF]">
                                <span class="text-gray-700 font-medium">No Further Action</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full mt-6 bg-[#AF00E4] hover:bg-[#9a00c9] text-white font-bold py-4 rounded-full shadow-lg transform hover:-translate-y-1 transition duration-200">
                            Submit Feedback
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
