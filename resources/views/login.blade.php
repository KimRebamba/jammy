@extends('layouts.customer')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto">
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-stone-900">Log in to Jammy</h1>
        <p class="text-stone-500 text-sm mt-1">Access your cart, orders, and reviews.</p>
    </div>

    {{-- @if(session('error'))
        <p class="text-sm text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </p>
    @endif --}}

    <form method="POST" action="/login" class="rounded-2xl border border-stone-200 bg-white shadow-lg shadow-stone-200/50 p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Password</label>
            <input type="password" name="password" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
        </div>

        <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 shadow-md shadow-amber-500/25">
            <i class="fa-solid fa-right-to-bracket"></i> Log in
        </button>
    </form>

    <p class="mt-4 text-sm text-stone-600 text-center">
        Don&apos;t have an account?
        <a href="/register" class="text-amber-600 hover:text-amber-700 font-medium">Sign up</a>
    </p>

    <p class="mt-2 text-center text-sm">
        <a href="/home" class="text-stone-500 hover:text-amber-600 inline-flex items-center gap-1">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to Home
        </a>
    </p>
</div>
@endsection