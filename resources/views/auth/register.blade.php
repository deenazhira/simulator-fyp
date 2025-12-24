@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-10 px-6">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow">

        <h2 class="text-3xl font-black mb-6 text-center">
            <span style="color:#651FFF;">User</span>
            <span style="color:#AF00E4;"> Register</span>
        </h2>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.user') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Name</label>
                <input name="name" value="{{ old('name') }}" required
                       class="w-full border rounded-lg px-4 py-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border rounded-lg px-4 py-2" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Trainer Email (Optional)</label>
                <p class="text-xs text-gray-500 mb-1">If you are a staff member, enter your trainer's email here to join their team.</p>
                <input type="email" name="trainer_email" value="{{ old('trainer_email') }}"
                    class="w-full border rounded-lg px-4 py-2" placeholder="manager@shell.com" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full border rounded-lg px-4 py-2" />
            </div>

            <!-- Confirm -->
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border rounded-lg px-4 py-2" />
            </div>

            <button type="submit"
                    style="background-color:#AF00E4;"
                    class="w-full text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
                Create User Account
            </button>

            <div class="mt-6 text-sm text-center">
                Registering as trainer?
                <a href="{{ route('register.trainer') }}"
                   class="hover:underline"
                   style="color:#651FFF;">
                    Register as Trainer
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
