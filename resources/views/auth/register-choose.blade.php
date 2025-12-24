@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#4A0080] font-sans px-4">

    <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-bold text-white tracking-wide drop-shadow-md">
            Join <span class="text-[#00E0FF]">PhishDefend AI</span>
        </h1>
        <p class="text-gray-200 mt-2 text-lg">Select your role to get started</p>
    </div>

    <div class="w-full max-w-4xl bg-[#9F85FF] p-8 md:p-12 rounded-3xl shadow-2xl">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <a href="{{ route('register.user') }}" class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition duration-300 ease-in-out cursor-pointer border-4 border-transparent hover:border-[#5D3EFF]">
                <div class="flex justify-center mb-6">
                    <div class="h-20 w-20 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 text-center mb-2 group-hover:text-purple-700">Normal User</h3>
                <p class="text-gray-500 text-center mb-6">
                    Access phishing quizzes, awareness materials, and basic dashboard features.
                </p>
                <div class="text-center">
                    <span class="inline-block px-6 py-2 bg-gray-200 text-gray-700 rounded-full font-semibold group-hover:bg-[#5D3EFF] group-hover:text-white transition-colors">
                        Register as User &rarr;
                    </span>
                </div>
            </a>

            <a href="{{ route('register.trainer') }}" class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition duration-300 ease-in-out cursor-pointer border-4 border-transparent hover:border-[#AF00E4]">
                <div class="flex justify-center mb-6">
                    <div class="h-20 w-20 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center group-hover:bg-[#AF00E4] group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 text-center mb-2 group-hover:text-[#AF00E4]">Trainer</h3>
                <p class="text-gray-500 text-center mb-6">
                    Manage staff, view team results, and provide feedback on performance.
                </p>
                <div class="text-center">
                    <span class="inline-block px-6 py-2 bg-gray-200 text-gray-700 rounded-full font-semibold group-hover:bg-[#AF00E4] group-hover:text-white transition-colors">
                        Register as Trainer &rarr;
                    </span>
                </div>
            </a>

        </div>

        <div class="mt-10 text-center">
            <p class="text-white text-lg">
                Already have an account?
                <a href="{{ route('login') }}" class="font-bold text-[#00E0FF] hover:text-white hover:underline ml-1 transition">
                    Log In here
                </a>
            </p>
        </div>

    </div>
</div>
@endsection

