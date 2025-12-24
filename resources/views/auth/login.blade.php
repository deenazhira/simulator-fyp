@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-10 px-6">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow border-t-4 border-blue-600">

        <h2 class="text-3xl font-black mb-6 text-center text-gray-800">
            Welcome Back
        </h2>

        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Email Address</label>
                <input type="email" name="user_email" value="{{ old('user_email') }}" required autofocus
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-1">Password</label>
                <input type="password" name="user_password" required
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
            </div>

            <button type="submit"
                    class="w-full bg-blue-700 text-white py-2 rounded-lg font-semibold hover:bg-blue-800 transition">
                Log In
            </button>

            <div class="mt-6 text-sm text-center">
                Don't have an account? <br>
                <a href="{{ route('register.user') }}" class="text-blue-600 hover:underline">Register as User</a>
                <span class="mx-2 text-gray-400">|</span>
                <a href="{{ route('register.trainer') }}" class="text-purple-600 hover:underline">Register as Trainer</a>
            </div>
        </form>
    </div>
</div>
@endsection

