<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PhishDefend AI</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <header class="bg-white shadow fixed w-full z-50">
    <div class="container mx-auto flex justify-between items-center p-5">
      <h1 class="text-2xl font-bold text-purple-700">PhishDefend AI</h1>
      <nav class="space-x-6">
        <a href="#home" class="hover:text-purple-700 font-medium">Home</a>
        <a href="#simulator" class="hover:text-purple-700 font-medium">Simulator</a>
        <a href="#chatbot" class="hover:text-purple-700 font-medium">Chatbot</a>
        <a href="#feedback" class="hover:text-purple-700 font-medium">Feedback</a>
        <a href="#awareness" class="hover:text-purple-700 font-medium">Awareness</a>
      </nav>
      <a href="#get-started" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">Get Started</a>
    </div>
  </header>

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
      <!-- Left Image -->
      <div class="md:w-1/2 flex justify-center">
        <img src="{{ asset('images/about-us.svg') }}" alt="About PhishDefend AI" class="w-96 md:w-[450px] rounded-lg shadow-lg">
      </div>

      <!-- Right Text -->
      <div class="md:w-1/2 text-left">
        <h3 class="text-3xl font-bold text-purple-800 mb-4">ABOUT US</h3>
        <p class="text-gray-700 leading-relaxed mb-4">
          <strong>PhishDefend AI</strong> is an educational and detection platform designed to raise awareness about phishing attacks.
          Our mission is to empower users with the tools and knowledge to identify and avoid malicious links, suspicious emails,
          and cyber threats using AI-driven insights.
        </p>
        <p class="text-gray-700 leading-relaxed">
          We aim to build a safer digital world by combining intelligent phishing detection with interactive learning —
          making cybersecurity accessible and engaging for everyone.
        </p>
      </div>
    </div>
  </section>

  <!-- Video Tutorial -->
  <section id="video" class="py-20 bg-purple-50 text-center">
    <h3 class="text-3xl font-semibold text-purple-700 mb-6">WATCH HOW IT WORKS</h3>
    <div class="container mx-auto">
      <iframe class="mx-auto w-full md:w-3/4 h-96 rounded-lg shadow-lg"
              src="https://www.youtube.com/embed/YOUR_VIDEO_ID"
              title="PhishDefend AI Tutorial" allowfullscreen></iframe>
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
          <a href="#chatbot" class="inline-block bg-purple-600 text-white px-5 py-2 rounded-lg hover:bg-purple-700 transition">Chat Now</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section id="pricing" class="py-20 bg-purple-50 text-center">
    <h3 class="text-3xl font-semibold text-purple-700 mb-10">PRICING PLANS</h3>
    <div class="grid md:grid-cols-2 gap-8 container mx-auto px-6">

      <!-- Individual Plan -->
      <div class="bg-white rounded-xl shadow-lg p-8 border-t-4 border-purple-600">
        <h4 class="text-2xl font-semibold text-purple-800 mb-4">Individual Plan</h4>
        <p class="text-gray-700 mb-4">Access AI tools, phishing quiz, and educational content for personal learning.</p>
        <p class="text-3xl font-bold text-purple-700 mb-6">FREE</p>
        <a href="#" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">Register Now</a>
      </div>

      <!-- Enterprise Plan -->
      <div class="bg-white rounded-xl shadow-lg p-8 border-t-4 border-purple-600">
        <h4 class="text-2xl font-semibold text-purple-800 mb-4">Enterprise Plan</h4>
        <p class="text-gray-700 mb-4">Comprehensive phishing protection and training suite for organizations.</p>
        <p class="text-3xl font-bold text-purple-700 mb-6">RM2,500/month</p>
        <a href="#" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">Get Started</a>
      </div>
    </div>
  </section>

  <!-- Feedback -->
  <section id="feedback" class="py-20 bg-white text-center">
    <h3 class="text-3xl font-semibold text-purple-700 mb-10">FEEDBACK FROM OUR CUSTOMERS</h3>
    <div class="grid md:grid-cols-3 gap-8 container mx-auto px-6">

      <div class="bg-purple-50 p-6 rounded-xl shadow hover:shadow-lg transition">
        <p class="text-gray-700 italic mb-4">"PhishDefend AI made me realize how easily I could fall for fake emails. The quiz is super helpful!"</p>
        <h4 class="font-bold text-purple-800">— Aina Rahman</h4>
      </div>

      <div class="bg-purple-50 p-6 rounded-xl shadow hover:shadow-lg transition">
        <p class="text-gray-700 italic mb-4">"The chatbot feature is amazing! I learned to spot phishing links in minutes."</p>
        <h4 class="font-bold text-purple-800">— Syafiq Hassan</h4>
      </div>

      <div class="bg-purple-50 p-6 rounded-xl shadow hover:shadow-lg transition">
        <p class="text-gray-700 italic mb-4">"Simple, clean, and very educational. Highly recommended for students and staff."</p>
        <h4 class="font-bold text-purple-800">— Nurul Izzah</h4>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-purple-800 text-white py-6 text-center">
    <p>© 2025 PhishDefend AI | All Rights Reserved</p>
  </footer>

</body>
</html>
