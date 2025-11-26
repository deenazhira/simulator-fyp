@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="home" class="pt-32 pb-20 bg-gradient-to-b from-purple-50 to-white">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between px-6">
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
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-10 px-6">
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

<!-- Video Tutorial -->
<section id="demo" class="py-20 bg-gradient-to-b from-purple-50 to-white">
    <div class="max-w-6xl mx-auto text-center px-6">
        <h3 class="text-3xl font-semibold text-purple-700 mb-10">VIDEO TUTORIAL</h3>
        <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-xl overflow-hidden shadow-lg">
            <iframe class="w-full h-[500px]" src="https://www.youtube.com/embed/your-video-id" title="PhishDefend AI Demo" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</section>

<!-- What We Offer -->
<section id="offer" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto text-center px-6">
        <h3 class="text-3xl font-semibold text-purple-700 mb-10">WHAT WE OFFER</h3>
        <div class="grid md:grid-cols-2 gap-8 justify-center">

            <!-- Simulation Quiz -->
            <div class="p-8 bg-purple-50 rounded-xl shadow hover:shadow-lg transition">
                <h4 class="font-bold text-xl text-purple-800 mb-3">Simulation Quiz</h4>
                <p class="text-gray-700 mb-6">Identify suspicious URLs and emails in real-time and test your phishing awareness.</p>
                <a href="{{ route('quiz.welcome') }}" class="inline-block bg-purple-600 text-white px-5 py-2 rounded-lg hover:bg-purple-700 transition">Start Quiz</a>


            </div>

            <!-- AI Chatbot -->
            <div class="p-8 bg-purple-50 rounded-xl shadow hover:shadow-lg transition">
                <h4 class="font-bold text-xl text-purple-800 mb-3">AI Chatbot</h4>
                <p class="text-gray-700 mb-6">Chat with our AI assistant to learn how to detect fraudulent sender patterns and red flags.</p>
<               <a href="{{ route('chatbot') }}">Chat Now</a>

            </div>
        </div>
    </div>
</section>

<!-- Pricing -->
<section id="pricing" class="py-20 bg-gradient-to-b from-purple-50 to-white">
    <div class="max-w-7xl mx-auto text-center px-6">
        <h3 class="text-3xl font-semibold text-purple-700 mb-10">PRICING PLAN</h3>
        <div class="grid md:grid-cols-2 gap-8">

            <!-- Individual -->
            <div class="p-8 border rounded-xl shadow hover:shadow-lg transition">
                <h4 class="text-xl font-bold text-purple-800 mb-3">Individual</h4>
                <p class="text-gray-600 mb-6">Access to phishing simulation quizzes and AI chatbot support.</p>
                <p class="text-3xl font-bold text-purple-700 mb-6">FREE</p>
                <a href="#register" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">Get Started</a>
            </div>

            <!-- Enterprise -->
            <div class="p-8 border rounded-xl shadow hover:shadow-lg transition">
                <h4 class="text-xl font-bold text-purple-800 mb-3">Enterprise</h4>
                <p class="text-gray-600 mb-6">Full suite for organizations — includes user management and reporting tools.</p>
                <p class="text-3xl font-bold text-purple-700 mb-6">RM250/MONTH</p>
                <a href="#contact" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Feedback -->
<section id="feedback" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto text-center px-6">
        <h3 class="text-3xl font-semibold text-purple-700 mb-10">USER FEEDBACK</h3>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-purple-50 p-6 rounded-xl shadow">
                <p class="italic text-gray-700 mb-4">"This tool really improved my awareness! The quiz is both fun and informative."</p>
                <h4 class="font-bold text-purple-800">— Sarah, Student</h4>
            </div>
            <div class="bg-purple-50 p-6 rounded-xl shadow">
                <p class="italic text-gray-700 mb-4">"The AI chatbot helped me understand phishing patterns easily."</p>
                <h4 class="font-bold text-purple-800">— Amir, IT Officer</h4>
            </div>
            <div class="bg-purple-50 p-6 rounded-xl shadow">
                <p class="italic text-gray-700 mb-4">"A great initiative for cybersecurity awareness. Very user-friendly!"</p>
                <h4 class="font-bold text-purple-800">— Aina, Educator</h4>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-purple-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8 text-center md:text-left">
        <div>
            <h4 class="font-bold text-lg mb-3">PhishDefend AI</h4>
            <p class="text-gray-300">Empowering users to stay safe online through AI-powered phishing awareness and education.</p>
        </div>
        <div>
            <h4 class="font-bold text-lg mb-3">Quick Links</h4>
            <ul class="space-y-2">
                <li><a href="#home" class="hover:text-yellow-400 transition">Home</a></li>
                <li><a href="#about" class="hover:text-yellow-400 transition">About</a></li>
                <li><a href="#pricing" class="hover:text-yellow-400 transition">Pricing</a></li>
                <li><a href="#feedback" class="hover:text-yellow-400 transition">Feedback</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold text-lg mb-3">Contact</h4>
            <p class="text-gray-300">Email: support@phishdefend.ai</p>
            <p class="text-gray-300">Phone: +60 12-345 6789</p>
        </div>
    </div>
    <div class="text-center text-gray-400 mt-10 border-t border-purple-700 pt-6">
        © 2025 PhishDefend AI. All rights reserved.
    </div>
</footer>
@endsection
