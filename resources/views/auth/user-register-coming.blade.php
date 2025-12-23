@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-10 px-6">
    <div class="w-full max-w-xl bg-white p-10 rounded-2xl shadow text-center">
        <h2 class="text-3xl font-black mb-3">
            <span style="color:#651FFF;">User</span><span style="color:#AF00E4;"> Registration</span>
        </h2>
        <p class="text-gray-600 mb-6">
            Normal user registration will be added next.
        </p>
        <a href="{{ route('register.trainer') }}"
           style="background-color:#AF00E4;"
           class="inline-block text-white px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition">
            Register as Trainer
        </a>
    </div>
</div>
@endsection
