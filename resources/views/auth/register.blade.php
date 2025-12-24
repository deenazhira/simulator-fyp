@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#4A0080] font-sans px-4 py-8">

    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-white tracking-wide">
            User <span class="text-[#00E0FF]">Registration</span>
        </h1>
        <p class="text-gray-200 mt-2 text-sm">Join to access PhishDefend quizzes & tools.</p>
    </div>

    <div class="w-full max-w-lg bg-[#9F85FF] p-8 rounded-3xl shadow-2xl relative">

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded text-sm">
                <p class="font-bold">Please fix the following errors:</p>
                <ul class="list-disc ml-5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.user') }}" x-data="{ showPass: false, showConfirm: false }">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-900 font-semibold mb-2 ml-1">Full Name</label>
                <input name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                       placeholder="Enter your name" />
            </div>

            <div class="mb-5">
                <label class="block text-gray-900 font-semibold mb-2 ml-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                       placeholder="name@example.com" />
            </div>

            <div class="mb-5 bg-white/30 p-4 rounded-xl border border-white/40">
                <label class="block text-gray-900 font-bold mb-1">Trainer Email <span class="text-gray-200 font-normal text-xs">(Optional)</span></label>
                <p class="text-xs text-gray-800 mb-2">Are you staff? Enter your manager's email to link your account.</p>
                <input type="email" name="trainer_email" value="{{ old('trainer_email') }}"
                       class="w-full px-4 py-2 rounded-lg border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-inner"
                       placeholder="manager@shell.com" />
            </div>

            <div class="mb-5 relative">
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label class="block text-gray-900 font-semibold">Password</label>
                    <button type="button" @click="showPass = !showPass" class="text-xs text-gray-800 hover:text-white focus:outline-none">
                        <span x-text="showPass ? 'Hide' : 'Show'"></span>
                    </button>
                </div>
                <input :type="showPass ? 'text' : 'password'" name="password" required
                       class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                       placeholder="Create a password" />
            </div>

            <div class="mb-8 relative">
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label class="block text-gray-900 font-semibold">Confirm Password</label>
                    <button type="button" @click="showConfirm = !showConfirm" class="text-xs text-gray-800 hover:text-white focus:outline-none">
                        <span x-text="showConfirm ? 'Hide' : 'Show'"></span>
                    </button>
                </div>
                <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                       class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                       placeholder="Repeat password" />
            </div>

            <button type="submit"
                    class="w-full block bg-[#5D3EFF] text-white py-3 rounded-full font-bold text-lg hover:bg-[#4a2fe0] transition shadow-lg transform hover:-translate-y-1">
                Create User Account
            </button>

            <div class="mt-8 pt-6 border-t border-purple-400/30 text-center space-y-3">

                <p class="text-gray-900 text-sm">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-bold text-white text-lg hover:text-[#00E0FF] hover:underline transition ml-1">
                        Log In
                    </a>
                </p>

                <p class="text-gray-800 text-xs">
                    Need a Trainer account?
                    <a href="{{ route('register.trainer') }}" class="font-semibold text-purple-900 hover:text-white hover:underline transition">
                        Register as Trainer
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection

