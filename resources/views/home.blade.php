@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="home" class="pt-32 pb-20 bg-gradient-to-b from-purple-50 to-white">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-6 md:px-12">
        <!-- Left Text -->
        <div class="md:w-1/2 text-left mb-10 md:mb-0">
            <h2 class="text-5xl font-extrabold mb-4 text-purple-800">
                PhishDefend <span class="text-purple-600">AI</span>
            </h2>
            <p class="text-gray-700 mb-8 leading-relaxed max-w-md">
                PhishDefend AI helps users detect and understand phishing attempts through smart AI analysis and educational tools.
            </p>
            <div class="space-x-4">
                <a href="#register"
                   class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg font-medium shadow-md hover:bg-purple-700 transition">
                   Create Account Now
                </a>
                <p class="inline-block text-gray-700 font-medium">
                    Watch Demo <a href="#demo" class="text-yellow-400 font-semibold hover:underline">Here</a>
                </p>
            </div>
        </div>

        <!-- Right Image -->
        <div class="md:w-1/2 flex justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="PhishDefend AI Illustration" class="w-96 md:w-[450px] rounded-lg shadow-lg">
        </div>
    </div>
</section>

<!-- About Us -->
<section id="about" class="py-20 bg-gradient-to-r from-purple-50 to-white">
    <div class="container mx-auto flex flex-col md:flex-row items-center gap-10 px-6 md:px-12">
        <div class="md:w-1/2 flex justify-center">
            <img src="{{ asset('images/about-us.svg') }}" alt="About PhishDefend AI" class="w-96 md:w-[450px] rounded-lg shadow-lg">
        </div>
        <div class="md:w-1/2 text-left">
            <h3 class="text-3xl font-bold text-purple-800 mb-4">ABOUT US</h3>
            <p class="text-gray-700 leading-relaxed mb-4">
                <strong>PhishDefend AI</strong> is an educational and detection platform designed to raise awareness about phishing attacks.
                Our mission is to empower users with the tools and knowledge to identify and avoid malicious links, suspicious emails,
                and cyber threats using AI-driven insights.
            </p>
            <p class="text-gray-700 leading-relaxed">
                We aim to build a safer digital world by combining intelligent phishing detection with interactive learning — making cybersecurity accessible and engaging for everyone.
            </p>
        </div>
    </div>
</section>

<!-- What We Offer -->
<section id="offer" class="py-20 bg-white">
    <div class="container mx-auto text-center">
        <h3 class="text-3xl font-semibold text-purple-700 mb-10">WHAT WE OFFER</h3>
        <div class="grid md:grid-cols-2 gap-8 justify-center">

            <!-- Simulation Quiz -->
            <div class="p-8 bg-purple-50 rounded-xl shadow hover:shadow-lg transition">
                <h4 class="font-bold text-xl text-purple-800 mb-3">Simulation Quiz</h4>
                <p class="text-gray-700 mb-6">Identify suspicious URLs and emails in real-time and test your phishing awareness.</p>
                <a href="#quiz" class="inline-block bg-purple-600 text-white px-5 py-2 rounded-lg hover:bg-purple-700 transition">Start Quiz</a>
            </div>

            <!-- AI Chatbot -->
            <div class="p-8 bg-purple-50 rounded-xl shadow hover:shadow-lg transition">
                <h4 class="font-bold text-xl text-purple-800 mb-3">AI Chatbot</h4>
                <p class="text-gray-700 mb-6">Chat with our AI assistant to learn how to detect fraudulent sender patterns and red flags.</p>
                <a href="{{ route('chatbot') }}" class="inline-block bg-purple-600 text-white px-5 py-2 rounded-lg hover:bg-purple-700 transition">Chat Now</a>
            </div>
        </div>
    </div>
</section>
@endsection
