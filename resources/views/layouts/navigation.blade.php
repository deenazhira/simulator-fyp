<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-8">
        <div class="h-20 flex items-center justify-between">

            <!-- LEFT: BRAND (BOLDER) -->
            <a href="{{ route('home') }}"
               class="text-3xl md:text-[32px] font-extrabold tracking-tight">
                <span style="color:#651FFF;">Phish</span><span style="color:#AF00E4;">Defend</span><span style="color:#AF00E4;"> AI</span>
            </a>

            <!-- CENTER: NAV LINKS -->
            <div class="flex items-center gap-10 text-lg font-medium text-gray-700">

                <a href="{{ route('home') }}"
                   class="hover:text-[#651FFF] transition
                   {{ request()->routeIs('home') ? 'text-[#651FFF] font-semibold' : '' }}">
                    Home
                </a>

                <a href="{{ route('quiz.welcome') }}"
                   class="hover:text-[#651FFF] transition
                   {{ request()->routeIs('quiz.*') ? 'text-[#651FFF] font-semibold' : '' }}">
                    Simulator
                </a>

                <a href="{{ route('chatbot') }}"
                   class="hover:text-[#651FFF] transition
                   {{ request()->routeIs('chatbot') ? 'text-[#651FFF] font-semibold' : '' }}">
                    Chatbot
                </a>

                <a href="#feedback"
                   class="hover:text-[#651FFF] transition">
                    Feedback
                </a>

                <a href="{{ url('/awareness') }}"
                   class="hover:text-[#651FFF] transition
                   {{ request()->is('awareness') ? 'text-[#651FFF] font-semibold' : '' }}">
                    Awareness
                </a>
            </div>

            <!-- RIGHT: AUTH -->
            <div class="flex items-center gap-6 text-sm font-medium">

                @guest
                    <a href="{{ url('/login') }}"
                       class="text-gray-700 hover:text-[#651FFF] transition">
                        Log in
                    </a>

                    <a href="{{ url('/register') }}"
   style="background-color:#AF00E4;"
   class="text-white px-6 py-2 rounded-lg font-semibold
          hover:opacity-90 transition shadow-sm">
    Register
</a>

                @endguest

                @auth
                    <span class="text-[#651FFF] font-semibold">
                        {{ Auth::user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-gray-700 hover:text-red-500 transition">
                            Log out
                        </button>
                    </form>
                @endauth

            </div>
        </div>
    </div>
</nav>
