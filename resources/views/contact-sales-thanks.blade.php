@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#4A0080] font-sans px-4 py-10 text-center">
    <div class="max-w-xl bg-white/10 border border-white/20 rounded-3xl p-10 shadow-2xl">
        <h1 class="text-3xl font-bold text-white mb-3">Thanks! 🎉</h1>
        <p class="text-gray-200 mb-8">
            We’ve received your request. Our team will contact you soon.
        </p>

        <a href="{{ route('home') }}"
           class="inline-block px-8 py-3 bg-cyan-400 text-black rounded-full font-bold hover:bg-cyan-300 transition">
            Back to Home
        </a>
    </div>
</div>
@endsection
