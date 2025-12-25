<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-8">
        <div class="h-20 flex items-center justify-between">

            {{-- LOGO: Redirects Trainers to Dashboard, Everyone else to Home --}}
            <a href="{{ (Auth::check() && Auth::user()->user_role === 'trainer') ? route('dashboard') : route('home') }}"
               class="text-3xl md:text-[32px] font-extrabold tracking-tight">
                <span style="color:#651FFF;">Phish</span><span style="color:#AF00E4;">Defend</span><span style="color:#AF00E4;"> AI</span>
            </a>

            <div class="flex items-center gap-10 text-lg font-medium text-gray-700">

                {{-- TRAINER MENU (No Home Link) --}}
                @if(Auth::check() && Auth::user()->user_role === 'trainer')
                    <a href="{{ route('dashboard') }}"
                       class="hover:text-[#651FFF] transition {{ request()->routeIs('dashboard') ? 'text-[#651FFF] font-semibold' : '' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('trainer.feedback.index') }}"
                       class="hover:text-[#651FFF] transition {{ request()->routeIs('trainer.feedback.index') ? 'text-[#651FFF] font-semibold' : '' }}">
                        Feedback
                    </a>

                    <a href="{{ url('/awareness') }}"
                       class="hover:text-[#651FFF] transition {{ request()->is('awareness') ? 'text-[#651FFF] font-semibold' : '' }}">
                        Awareness
                    </a>

                {{-- PUBLIC & GUEST MENU (Has Home Link) --}}
                @else
                    {{-- Home Link is here now, so Trainers won't see it --}}
                    <a href="{{ route('home') }}"
                       class="hover:text-[#651FFF] transition {{ request()->routeIs('home') ? 'text-[#651FFF] font-semibold' : '' }}">
                        Home
                    </a>

                    <a href="{{ route('quiz.welcome') }}"
                       class="hover:text-[#651FFF] transition {{ request()->routeIs('quiz.*') ? 'text-[#651FFF] font-semibold' : '' }}">
                        Simulator
                    </a>

                    <a href="{{ route('chatbot') }}"
                       class="flex items-center gap-1 hover:text-[#651FFF] transition {{ request()->routeIs('chatbot') ? 'text-[#651FFF] font-semibold' : '' }}">
                        Chatbot

                        {{-- Lock Icon for Free (Public) Users --}}
                        @if(Auth::check() && Auth::user()->user_role === 'public')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </a>

                    <a href="{{ route('user.feedback.index') }}"
                        class="hover:text-[#651FFF] transition {{ request()->routeIs('user.feedback.index') ? 'text-[#651FFF] font-semibold' : '' }}">
                        Feedback
                    </a>

                    <a href="{{ url('/awareness') }}"
                       class="hover:text-[#651FFF] transition {{ request()->is('awareness') ? 'text-[#651FFF] font-semibold' : '' }}">
                        Awareness
                    </a>
                @endif
            </div>

            <div class="flex items-center gap-6 text-sm font-medium">

                @guest
                    <a href="{{ url('/login') }}" class="text-gray-700 hover:text-[#651FFF] transition">
                        Log in
                    </a>

                    <a href="{{ route('register.choose') }}"
                       style="background-color:#AF00E4;"
                       class="text-white px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition shadow-sm">
                        Register
                    </a>
                @endguest

                @auth
                    <span class="text-[#651FFF] font-semibold">
                        {{ Auth::user()->user_name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-500 transition">
                            Log out
                        </button>
                    </form>
                @endauth

            </div>
        </div>
    </div>
</nav>

