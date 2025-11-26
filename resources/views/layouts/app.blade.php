<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhishDefend AI</title>

    <!-- Tailwind CSS (for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Navbar -->
    <header class="bg-white shadow fixed w-full z-50">
        <div class="container mx-auto flex justify-between items-center p-5">
            <h1 class="text-2xl font-bold text-purple-700">PhishDefend AI</h1>
            <nav class="space-x-6">
                <a href="{{ url('/') }}" class="hover:text-purple-700 font-medium">Home</a>
                <a href="{{ url('/quiz') }}" class="hover:text-purple-700 font-medium">Quiz</a>
                <a href="{{ route('chatbot') }}" class="hover:text-purple-700 font-medium">Chatbot</a>

                <a href="#feedback" class="hover:text-purple-700 font-medium">Feedback</a>
                <a href="{{ url('/awareness') }}" class="hover:text-purple-700 font-medium">Awareness</a>
            </nav>
            <a href="#get-started" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">Get Started</a>
        </div>
    </header>

    <!-- Main content -->
    <main class="pt-24 container mx-auto px-4">
        @yield('content')
    </main>

</body>
</html>
