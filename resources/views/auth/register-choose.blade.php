@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-10 px-6">
    <div class="w-full max-w-xl bg-white p-10 rounded-2xl shadow">

        <h2 class="text-3xl font-black text-center mb-3">
            <span style="color:#651FFF;">Choose</span>
            <span style="color:#AF00E4;"> Account Type</span>
        </h2>

        <p class="text-center text-gray-600 mb-8">
            Select how you want to register.
        </p>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Normal User -->
            <a href="{{ url('/register/user') }}"
               class="border rounded-xl p-6 hover:shadow-md transition">
                <h3 class="text-xl font-bold mb-2" style="color:#651FFF;">Normal User</h3>
                <p class="text-gray-600 text-sm">
                    Access quizzes, chatbot and awareness tools.
                </p>
                <div class="mt-4 text-sm font-semibold" style="color:#651FFF;">
                    Register as User →
                </div>
            </a>

            <!-- Trainer -->
            <a href="{{ url('/register/trainer') }}"
               class="border rounded-xl p-6 hover:shadow-md transition">
                <h3 class="text-xl font-bold mb-2" style="color:#AF00E4;">Trainer</h3>
                <p class="text-gray-600 text-sm">
                    Trainer tools and extra management access.
                </p>
                <div class="mt-4 text-sm font-semibold" style="color:#AF00E4;">
                    Register as Trainer →
                </div>
            </a>
        </div>

        <div class="text-center mt-8 text-sm">
            Already have an account?
            <a href="{{ url('/login') }}" class="hover:underline" style="color:#651FFF;">Log in</a>
        </div>
    </div>
</div>
@endsection
