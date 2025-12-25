@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#4A0080] font-sans px-4 py-10">

    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-white tracking-wide">
            Contact <span class="text-[#00E0FF]">Sales</span>
        </h1>
        <p class="text-gray-200 mt-2 text-sm">
            Fill this form and we’ll reach out to you.
        </p>
    </div>

    <div class="w-full max-w-lg bg-[#9F85FF] p-8 rounded-3xl shadow-2xl relative overflow-hidden">

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded text-sm">
                <p class="font-bold">Oops! Something went wrong:</p>
                <ul class="list-disc ml-5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('contact.sales.store') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-900 font-semibold mb-2 ml-1">Full Name</label>
                <input name="full_name" value="{{ old('full_name') }}" required
                       class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                       placeholder="Enter your full name" />
            </div>

            <div class="mb-5">
                <label class="block text-gray-900 font-semibold mb-2 ml-1">Company / Department</label>
                <input name="company_name" value="{{ old('company_name') }}" required
                       class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                       placeholder="e.g. Shell Security Team" />
            </div>

            <div class="mb-5">
                <label class="block text-gray-900 font-semibold mb-2 ml-1">Work Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                       placeholder="name@company.com" />
            </div>

            <div class="mb-5">
                <label class="block text-gray-900 font-semibold mb-2 ml-1">Phone (optional)</label>
                <input name="phone" value="{{ old('phone') }}"
                       class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                       placeholder="+60 12-345 6789" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-gray-900 font-semibold mb-2 ml-1">Your Role (optional)</label>
                    <input name="role" value="{{ old('role') }}"
                           class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                           placeholder="IT Officer" />
                </div>

                <div>
                    <label class="block text-gray-900 font-semibold mb-2 ml-1">Team Size (optional)</label>
                    <input type="number" min="1" name="team_size" value="{{ old('team_size') }}"
                           class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                           placeholder="50" />
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-gray-900 font-semibold mb-2 ml-1">Message (optional)</label>
                <textarea name="message" rows="4"
                          class="w-full px-4 py-3 rounded-xl border-none focus:ring-2 focus:ring-[#5D3EFF] text-gray-800 placeholder-gray-400 bg-white shadow-sm"
                          placeholder="Tell us what you need...">{{ old('message') }}</textarea>
            </div>

            <button type="submit"
                    class="w-full block bg-[#5D3EFF] text-white py-3 rounded-full font-bold text-lg hover:bg-[#4a2fe0] transition shadow-lg transform hover:-translate-y-1">
                Submit
            </button>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-white font-semibold hover:text-[#00E0FF] hover:underline transition">
                    ← Back to Home
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
