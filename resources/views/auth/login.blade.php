@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#4A0080] font-sans">

    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-white tracking-wide">
            Phish<span class="text-[#00E0FF]">Defend AI</span>
        </h1>
    </div>

    <div class="w-full max-w-md bg-[#9F85FF] p-8 rounded-2xl shadow-2xl">

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded text-sm text-center">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded text-sm text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-900 font-semibold mb-2 ml-1 text-lg">Email</label>
                <input type="email" name="user_email" value="{{ old('user_email') }}" required autofocus
                       class="w-full px-4 py-3 rounded-lg border-none focus:ring-2 focus:ring-blue-400 text-gray-800 placeholder-gray-400 bg-white"
                       placeholder="Enter your email" />
            </div>

            <div class="mb-2 relative" x-data="{ show: false }">
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label class="block text-gray-900 font-semibold text-lg">Password</label>

                    <button type="button" @click="show = !show" class="text-sm text-gray-800 flex items-center gap-1 focus:outline-none hover:text-gray-600">
                        <span x-show="!show" class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            Hide
                        </span>
                        <span x-show="show" class="flex items-center gap-1" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            Show
                        </span>
                    </button>
                </div>

                <input :type="show ? 'text' : 'password'" name="user_password" required
                       class="w-full px-4 py-3 rounded-lg border-none focus:ring-2 focus:ring-blue-400 text-gray-800 bg-white"
                       placeholder="Enter your password" />
            </div>

            <div class="text-right mb-8">
                <a href="#" class="text-sm text-gray-800 hover:text-white hover:underline transition">
                    Forget Password
                </a>
            </div>

            <button type="submit"
                    class="w-40 mx-auto block bg-[#5D3EFF] text-white py-3 rounded-full font-bold text-lg hover:bg-[#4a2fe0] transition shadow-lg">
                Log in
            </button>

            <div class="mt-8 text-center text-gray-900 text-sm">
                New user?
                <a href="{{ route('register.user') }}" class="font-bold hover:underline">Sign Up</a>
                <span class="mx-1">|</span>
                <a href="{{ route('register.trainer') }}" class="font-bold hover:underline">Trainer Sign Up</a>
            </div>
        </form>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection

