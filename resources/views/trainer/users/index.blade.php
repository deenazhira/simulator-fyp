@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-7xl mx-auto">

        <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('trainer.dashboard') }}" class="hover:text-purple-600">Dashboard</a>
            <span>/</span>
            <span class="font-semibold text-gray-800">Manage Users</span>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manage Users</h1>
            <div class="flex items-center gap-3">
                <span class="text-gray-500 text-sm">Total Staff: <strong>{{ count($users) }}</strong></span>
                <button class="bg-green-500 text-white px-6 py-2 rounded-full font-bold hover:bg-green-600 transition shadow-md">
                    Save Changes
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-lg text-[#651FFF]">Users List</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-50 bg-gray-50/50">
                            <th class="p-5 font-semibold">Staff ID</th>
                            <th class="p-5 font-semibold">Staff Name</th>
                            <th class="p-5 font-semibold">Department</th>
                            <th class="p-5 font-semibold text-center">Avg Success Rate</th>
                            <th class="p-5 font-semibold text-center">Manage</th>
                            <th class="p-5 font-semibold text-right">View</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach($users as $user)
                        <tr class="hover:bg-purple-50/30 transition border-b border-gray-50 last:border-0 group">

                            <td class="p-5 font-mono text-sm text-gray-500">{{ $user['staff_id'] }}</td>

                            <td class="p-5">
                                <div class="font-bold text-gray-800">{{ $user['name'] }}</div>
                                <div class="text-xs text-gray-400">{{ $user['email'] }}</div>
                            </td>

                            <td class="p-5">
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $user['department'] }}
                                </span>
                            </td>

                            <td class="p-5 text-center">
                                <span class="font-bold {{ $user['avg_score'] >= 80 ? 'text-green-600' : ($user['avg_score'] < 50 ? 'text-red-600' : 'text-yellow-600') }}">
                                    {{ $user['avg_score'] }}%
                                </span>
                            </td>

                            <td class="p-5 text-center">
                                <form action="{{ route('trainer.users.remove', $user['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this user from your team?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 border border-red-200 px-4 py-1 rounded hover:bg-red-50 hover:border-red-500 transition text-sm font-medium">
                                        Remove User
                                    </button>
                                </form>
                            </td>

                            <td class="p-5 text-right">
                                <a href="{{ route('trainer.users.show', $user['id']) }}" class="text-cyan-500 border border-cyan-200 px-4 py-1 rounded hover:bg-cyan-50 hover:border-cyan-500 transition text-sm font-medium">
                                    User Activity
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if(count($users) === 0)
                            <tr>
                                <td colspan="6" class="p-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        <p>No users currently linked to your account.</p>
                                    </div>
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
