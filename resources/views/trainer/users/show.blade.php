@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-5xl mx-auto">

        <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('trainer.dashboard') }}" class="hover:text-purple-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('trainer.users.index') }}" class="hover:text-purple-600">Manage Users</a>
            <span>/</span>
            <span class="font-semibold text-gray-800">{{ $user->user_name }}</span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8 flex flex-col md:flex-row items-center md:items-start gap-8">
            <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center text-3xl font-bold text-purple-600">
                {{ substr($user->user_name, 0, 1) }}
            </div>

            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ $user->user_name }}</h1>
                <p class="text-gray-500 mb-4">{{ $user->user_email }}</p>

                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <span class="px-4 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-600">
                        Department: {{ $user->company_name ?? 'General' }}
                    </span>
                    <span class="px-4 py-1 rounded-full text-sm font-semibold {{ $riskColor }}">
                        {{ $riskStatus }}
                    </span>
                </div>
            </div>

            <div class="flex gap-6 text-center">
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ $totalQuizzes }}</div>
                    <div class="text-xs text-gray-500 uppercase">Quizzes</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ round($avgScore) }}%</div>
                    <div class="text-xs text-gray-500 uppercase">Avg Score</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-lg text-gray-800">Activity History</h3>
            </div>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase bg-gray-50">
                        <th class="p-5">Date</th>
                        <th class="p-5">Activity</th>
                        <th class="p-5 text-center">Score</th>
                        <th class="p-5 text-center">Status</th>
                        <th class="p-5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach($quizResults as $result)
                    <tr class="border-b border-gray-50 hover:bg-purple-50/20 transition">
                        <td class="p-5 text-sm">
                            {{ \Carbon\Carbon::parse($result->created_at)->format('M d, Y') }}
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($result->created_at)->format('h:i A') }}</div>
                        </td>
                        <td class="p-5 font-semibold text-gray-800">
                            Phishing Simulation Quiz
                        </td>
                        <td class="p-5 text-center font-bold">
                            {{ $result->score }}%
                        </td>
                        <td class="p-5 text-center">
                            @if($result->score >= 80)
                                <span class="text-green-600 bg-green-100 px-3 py-1 rounded text-xs font-bold">PASSED</span>
                            @else
                                <span class="text-red-600 bg-red-100 px-3 py-1 rounded text-xs font-bold">FAILED</span>
                            @endif
                        </td>
                        <td class="p-5 text-right">
                            <a href="#" class="text-white bg-[#651FFF] px-4 py-2 rounded-lg text-sm font-semibold hover:bg-purple-700 shadow-sm">
                                Give Feedback
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    @if($quizResults->isEmpty())
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-400">
                            No activity recorded yet for this user.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
