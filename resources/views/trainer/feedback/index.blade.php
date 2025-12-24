@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Feedback Center</h1>
                <p class="text-gray-500 mt-1">Review and grade simulation attempts from your team.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-wider bg-gray-50 border-b border-gray-100">
                        <th class="p-6">Date</th>
                        <th class="p-6">Staff Name</th>
                        <th class="p-6 text-center">Score</th>
                        <th class="p-6 text-center">Status</th>
                        <th class="p-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach($attempts as $attempt)
                    <tr class="border-b border-gray-50 hover:bg-purple-50/20 transition group">

                        <td class="p-6 text-sm">
                            {{ \Carbon\Carbon::parse($attempt->quiz_date)->format('M d, Y') }}
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($attempt->quiz_date)->format('h:i A') }}</div>
                        </td>

                        <td class="p-6">
                            <div class="font-bold text-gray-800">{{ $attempt->user_name }}</div>
                            <div class="text-xs text-gray-400">{{ $attempt->user_email }}</div>
                        </td>

                        <td class="p-6 text-center">
                            <span class="font-bold {{ $attempt->score >= 80 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $attempt->score }}%
                            </span>
                        </td>

                        <td class="p-6 text-center">
                            @if($attempt->feedback_id)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                    Completed
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200 animate-pulse">
                                    Pending Review
                                </span>
                            @endif
                        </td>

                        <td class="p-6 text-right">
                            @if($attempt->feedback_id)
                                <button disabled class="text-gray-400 border border-gray-200 px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed">
                                    View Feedback
                                </button>
                            @else
                                <a href="{{ route('trainer.feedback.create', $attempt->result_id) }}"
                                   class="bg-[#651FFF] text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-purple-700 shadow-md transition transform hover:-translate-y-0.5">
                                    Give Feedback
                                </a>
                            @endif
                        </td>

                    </tr>
                    @endforeach

                    @if($attempts->isEmpty())
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-400">
                            No simulation attempts found to review.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
