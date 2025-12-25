@extends('layouts.app')

@section('content')

<section id="home" class="relative pt-32 pb-20 overflow-hidden bg-[#4A0080]">
    <div class="absolute inset-0 bg-gradient-to-br from-[#4A0080] via-[#5D3EFF] to-[#2E0050]"></div>

    <div class="absolute top-0 left-0 w-96 h-96 bg-purple-400 rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-400 rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s"></div>

    <div class="relative max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between px-6 z-10">
        <div class="md:w-1/2 text-left mb-12 md:mb-0">

            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 text-white drop-shadow-lg">
                Phish<span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-blue-400">Defend</span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-pink-300"> AI</span>
            </h1>
            <p class="text-gray-100 text-lg md:text-xl leading-relaxed max-w-xl mb-10 opacity-90">
                Train yourself with AI-powered simulations and real-life scenarios.
                <span class="text-cyan-300 font-semibold">Detect. Defend. Defeat.</span>
            </p>

            <div class="flex flex-wrap items-center gap-6">
                @guest
                    <a href="{{ url('/register') }}" class="px-8 py-4 bg-cyan-400 text-black rounded-full font-bold text-lg shadow-lg hover:bg-cyan-300 hover:scale-105 transition transform duration-200">
                        Create Account
                    </a>
                @endguest

                @auth
                    @if(Auth::user()->user_role === 'trainer')
                    {{-- Trainers still need the Dashboard --}}
                    <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-cyan-400 text-black rounded-full font-bold text-lg shadow-lg hover:bg-cyan-300 hover:scale-105 transition transform duration-200">
                        Go to Dashboard
                    </a>
                    @else
                    {{-- ✅ FREE USERS: Change "Go to Dashboard" to "Go to Simulator" --}}
                    <a href="{{ route('quiz.welcome') }}" class="px-8 py-4 bg-cyan-400 text-black rounded-full font-bold text-lg shadow-lg hover:bg-cyan-300 hover:scale-105 transition transform duration-200">
                        Go to Simulator
                    </a>
                    @endif
                @endauth

                <a href="#demo" class="flex items-center gap-2 text-white font-medium hover:text-cyan-300 transition group">
                    <span class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-white/20">
                        ▶
                    </span>
                    Watch Demo
                </a>
            </div>
        </div>

        <div class="md:w-1/2 flex justify-center relative">
            <img src="{{ asset('images/logo-phish.png') }}" alt="Hero Illustration" class="relative w-full max-w-xl drop-shadow-2xl hover:scale-105 transition duration-500">
        </div>
    </div>
</section>


<section id="about" class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16 px-6">
        <div class="md:w-1/2">
            <img src="{{ asset('images/aboutus.png') }}" alt="About Us" class="w-full max-w-md mx-auto drop-shadow-2xl hover:-rotate-2 transition duration-500">
        </div>
        <div class="md:w-1/2">
            <h3 class="text-sm font-bold tracking-widest text-purple-600 mb-2 uppercase">Who We Are</h3>
            <h2 class="text-4xl font-extrabold text-[#4A0080] mb-6">Empowering Your Digital Safety</h2>
            <p class="text-gray-600 text-lg leading-relaxed mb-6">
                <strong>PhishDefend AI</strong> isn't just a quiz; it's an intelligent defense platform. We combine machine learning with interactive education to help you identify malicious links before you click.
            </p>
            <ul class="space-y-3 mb-8">
                <li class="flex items-center text-gray-700">
                    <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-3">✓</span>
                    Real-world phishing scenarios
                </li>
                <li class="flex items-center text-gray-700">
                    <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-3">✓</span>
                    Instant AI feedback on your choices
                </li>
            </ul>
        </div>
    </div>
</section>


<section id="demo" class="py-16 bg-[#1a0b2e]">
    <div class="max-w-4xl mx-auto text-center px-6 relative z-10">
        <h2 class="text-3xl font-bold text-white mb-4">See It In Action</h2>
        <p class="text-purple-200 mb-8">Watch how our AI analyzes threats in real-time.</p>

        <div class="rounded-xl overflow-hidden shadow-[0_10px_30px_rgba(8,_112,_184,_0.5)] border border-purple-500/30">
            <div class="aspect-w-16 aspect-h-9 bg-black">
                <iframe class="w-full h-[400px]" src="https://www.youtube.com/embed/your-video-id" title="PhishDefend AI Demo" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>


<section id="offer" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900">What We Offer</h2>
            <p class="text-gray-500 mt-4">Tools designed for both beginners and experts.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-10 max-w-5xl mx-auto">
            <div class="group p-8 rounded-3xl border border-gray-100 bg-white shadow-xl hover:shadow-2xl hover:border-purple-300 transition duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-100 rounded-full mix-blend-multiply filter blur-2xl opacity-50 transform translate-x-10 -translate-y-10 group-hover:bg-purple-200 transition"></div>

                <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-purple-600/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Simulation Quiz</h3>
                <p class="text-gray-600 mb-8">Test your skills against realistic emails. Get graded instantly and learn from mistakes.</p>
                <a href="{{ route('quiz.welcome') }}" class="text-purple-600 font-bold hover:text-purple-800 flex items-center">Start Simulation &rarr;</a>
            </div>

            <div class="group p-8 rounded-3xl border border-gray-100 bg-white shadow-xl hover:shadow-2xl hover:border-cyan-300 transition duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-100 rounded-full mix-blend-multiply filter blur-2xl opacity-50 transform translate-x-10 -translate-y-10 group-hover:bg-cyan-200 transition"></div>

                <div class="w-16 h-16 bg-cyan-500 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">AI Chatbot</h3>
                <p class="text-gray-600 mb-8">Unsure about a link? Ask our AI. It analyzes patterns to detect fraud instantly.</p>
                <a href="{{ route('chatbot') }}" class="text-cyan-600 font-bold hover:text-cyan-800 flex items-center">Chat Now &rarr;</a>
            </div>
        </div>
    </div>
</section>


<section id="pricing" class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-purple-50"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-[#4A0080]">Choose Your Path</h2>
            <p class="text-gray-500 mt-4">Transparent pricing for everyone.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white p-10 rounded-3xl shadow-lg border border-gray-100 hover:-translate-y-2 transition duration-300">
                <span class="bg-gray-100 text-gray-600 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Individual</span>
                <div class="mt-4 mb-6">
                    <span class="text-5xl font-extrabold text-gray-900">Free</span>
                    <span class="text-gray-400">/ forever</span>
                </div>
                <ul class="space-y-4 mb-8 text-gray-600">
                    <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Access to Quizzes</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Basic AI Awareness</li>
                </ul>
                @guest
                    <a href="{{ url('/register') }}" class="block w-full py-4 text-center rounded-xl font-bold text-[#4A0080] bg-purple-50 hover:bg-purple-100 transition">Create Account</a>
                @else
                    <button disabled class="block w-full py-4 text-center rounded-xl font-bold text-gray-400 bg-gray-100 cursor-not-allowed">Current Plan</button>
                @endguest
            </div>

            <div class="bg-[#4A0080] p-10 rounded-3xl shadow-2xl text-white transform md:scale-105 hover:-translate-y-2 transition duration-300 relative">
                <div class="absolute top-0 right-0 bg-cyan-400 text-[#4A0080] text-xs font-bold px-4 py-1 rounded-bl-xl rounded-tr-2xl">POPULAR</div>
                <span class="bg-white/20 text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Enterprise</span>
                <div class="mt-4 mb-6">
                    <span class="text-5xl font-extrabold">RM250</span>
                    <span class="text-purple-200">/ mo</span>
                </div>
                <ul class="space-y-4 mb-8 text-purple-100">
                    <li class="flex items-center"><svg class="w-5 h-5 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Unlimited AI Chatbot</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Trainer Dashboard</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Team Analytics</li>
                </ul>
                <a href="#contact" class="block w-full py-4 text-center rounded-xl font-bold text-black bg-cyan-400 hover:bg-cyan-300 transition shadow-[0_0_20px_rgba(34,211,238,0.5)]">Contact Sales</a>
            </div>
        </div>
    </div>
</section>


<section id="feedback" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto text-center px-6">
        <h3 class="text-3xl font-bold text-gray-900 mb-12">Past Feedbacks</h3>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-purple-100 p-8 rounded-2xl shadow-sm hover:shadow-md hover:bg-purple-200 transition border border-purple-200">
                <div class="flex text-yellow-500 justify-center mb-4">★★★★★</div>
                <p class="italic text-purple-900 mb-6">"This tool really improved my awareness! The quiz is both fun and informative."</p>
                <h4 class="font-bold text-purple-800">— Sarah, Student</h4>
            </div>

            <div class="bg-purple-100 p-8 rounded-2xl shadow-sm hover:shadow-md hover:bg-purple-200 transition border border-purple-200">
                <div class="flex text-yellow-500 justify-center mb-4">★★★★★</div>
                <p class="italic text-purple-900 mb-6">"The AI chatbot helped me understand phishing patterns easily. Highly recommended!"</p>
                <h4 class="font-bold text-purple-800">— Amir, IT Officer</h4>
            </div>

            <div class="bg-purple-100 p-8 rounded-2xl shadow-sm hover:shadow-md hover:bg-purple-200 transition border border-purple-200">
                <div class="flex text-yellow-500 justify-center mb-4">★★★★☆</div>
                <p class="italic text-purple-900 mb-6">"A great initiative for cybersecurity awareness. Very user-friendly and modern."</p>
                <h4 class="font-bold text-purple-800">— Aina, Educator</h4>
            </div>
        </div>
    </div>
</section>


<footer class="bg-[#1a0b2e] text-white py-12 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12 text-center md:text-left">
        <div>
            <h4 class="font-bold text-2xl mb-4 tracking-wide">Phish<span class="text-cyan-400">Defend</span></h4>
            <p class="text-gray-400 text-sm leading-relaxed">
                Empowering organizations and individuals to stay safe online through advanced AI-powered detection and education.
            </p>
        </div>
        <div>
            <h4 class="font-bold text-lg mb-4 text-purple-300">Platform</h4>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                <li><a href="{{ route('quiz.welcome') }}" class="hover:text-white transition">Simulator</a></li>
                <li><a href="{{ route('chatbot') }}" class="hover:text-white transition">AI Chatbot</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold text-lg mb-4 text-purple-300">Contact</h4>
            <p class="text-gray-400 text-sm">support@phishdefend.ai</p>
            <p class="text-gray-400 text-sm">+60 12-345 6789</p>
        </div>
    </div>
    <div class="text-center text-gray-600 mt-12 pt-8 text-xs">
        © 2025 PhishDefend AI. All rights reserved.
    </div>
</footer>

@endsection

