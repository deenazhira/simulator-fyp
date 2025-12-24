@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#4A0080] flex items-center justify-center px-4">
    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row relative z-10">

        <div class="md:w-1/2 bg-gradient-to-br from-[#5D3EFF] to-[#4A0080] p-10 text-white flex flex-col justify-center items-center text-center">
            <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mb-6 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold mb-2">Premium Feature</h2>
            <p class="text-purple-200">The AI Chatbot is an Enterprise exclusive.</p>
        </div>

        <div class="md:w-1/2 p-10 bg-white">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Unlock AI Simulations</h3>
            <p class="text-gray-600 mb-8">Upgrade to the Enterprise Plan to practice detecting real-time phishing threats with our AI simulator.</p>

            <div class="space-y-4">
                <a href="#pricing" class="block w-full py-3 bg-[#4A0080] text-white text-center rounded-xl font-bold hover:opacity-90 transition shadow-lg">
                    Upgrade Now
                </a>
                <a href="{{ route('home') }}" class="block w-full py-3 bg-gray-100 text-gray-700 text-center rounded-xl font-semibold hover:bg-gray-200 transition">
                    Return Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

