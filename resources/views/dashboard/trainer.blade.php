@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Trainer's Dashboard</h2>
            <div class="text-gray-500">Welcome, <span class="font-bold text-[#651FFF]">{{ Auth::user()->user_name }}</span></div>
        </div>

        <div class="bg-gradient-to-r from-[#651FFF] to-[#AF00E4] rounded-2xl p-8 mb-8 text-white flex justify-between items-center shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full transform translate-x-10 -translate-y-10"></div>

            <div class="z-10">
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->user_name }}.</h1>
                <p class="text-purple-100 mb-6">Here is your team's phishing awareness overview.</p>
                <a href="#users-table" class="bg-white text-[#651FFF] px-6 py-2 rounded-full font-bold hover:bg-gray-100 transition">
                    View Users
                </a>
            </div>

            <div class="flex gap-4 z-10">
                <div class="bg-white/20 backdrop-blur-md p-4 rounded-xl text-center min-w-[100px]">
                    <div class="text-3xl font-bold">{{ $totalUsers }}</div>
                    <div class="text-xs text-purple-100 uppercase tracking-wide">Users</div>
                </div>
                <div class="bg-green-500/80 backdrop-blur-md p-4 rounded-xl text-center min-w-[100px]">
                    <div class="text-3xl font-bold">{{ $lowRiskCount }}</div>
                    <div class="text-xs text-white uppercase tracking-wide">Low Risk</div>
                </div>
                <div class="bg-red-500/80 backdrop-blur-md p-4 rounded-xl text-center min-w-[100px]">
                    <div class="text-3xl font-bold">{{ $highRiskCount }}</div>
                    <div class="text-xs text-white uppercase tracking-wide">High Risk</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-700">User Activity</h3>
                    <button class="text-sm text-[#651FFF] border border-[#651FFF] px-3 py-1 rounded-lg hover:bg-purple-50">
                        Download Report
                    </button>
                </div>
                <div class="h-48 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                    [ Activity Graph Visual Placeholder ]
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-700 mb-4">Risk Distribution</h3>
                <div class="h-48 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                    [ Pie Chart Placeholder ]
                </div>
            </div>
        </div>

        <div id="users-table" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 flex justify-between items-center border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-800">Team Performance</h3>
                <a href="{{ route('trainer.users.index') }}" class="bg-[#651FFF] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-purple-700">
                    Manage Users
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-sm uppercase tracking-wider border-b border-gray-50">
                            <th class="p-6 font-medium">Staff ID</th>
                            <th class="p-6 font-medium">Name</th>
                            <th class="p-6 font-medium">Dept</th>
                            <th class="p-6 font-medium text-center">Avg Score</th>
                            <th class="p-6 font-medium text-center">Risk Level</th>
                            <th class="p-6 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach($userStats as $stat)
                        <tr class="hover:bg-gray-50 transition border-b border-gray-50 last:border-0">
                            <td class="p-6 font-semibold">{{ $stat['staff_id'] }}</td>
                            <td class="p-6">
                                <div class="font-bold text-gray-800">{{ $stat['name'] }}</div>
                                <div class="text-xs text-gray-400">{{ $stat['email'] }}</div>
                            </td>
                            <td class="p-6">{{ $stat['department'] }}</td>
                            <td class="p-6 text-center font-bold">{{ $stat['avg_score'] }}%</td>
                            <td class="p-6 text-center">
                                @if($stat['risk_color'] == 'green')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Low Risk</span>
                                @elseif($stat['risk_color'] == 'red')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">High Risk</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Medium</span>
                                @endif
                            </td>
                            <td class="p-6 text-right">
                                <a href="{{ route('trainer.users.show', $stat['id']) }}" class="text-[#651FFF] border border-[#651FFF] px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#651FFF] hover:text-white transition">
                                    User Activity
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if(count($userStats) == 0)
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400">
                                No users found linked to your account.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
