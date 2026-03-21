@extends('layouts.customer')

@section('title', 'My Profile')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
        <i class="fa-solid fa-user text-amber-600 text-xl"></i>
    </div>
    <h2 class="text-xl font-bold text-stone-900">My Profile</h2>
</div>

@if($account)
    <div class="grid grid-cols-1 md:grid-cols-[minmax(0,2fr)_minmax(0,1.5fr)] gap-6 items-start">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-lg shadow-stone-200/50 p-6 space-y-3">
            <p class="text-stone-700"><strong class="inline-block w-28 text-stone-900">Username:</strong> {{ $account->username }}</p>
            <p class="text-stone-700"><strong class="inline-block w-28 text-stone-900">Email:</strong> {{ $account->email }}</p>
            <p class="text-stone-700"><strong class="inline-block w-28 text-stone-900">Name:</strong> {{ $account->first_name }} {{ $account->last_name }}</p>
            <p class="text-stone-700"><strong class="inline-block w-28 text-stone-900">Address:</strong> {{ $account->address }}</p>
            <p class="text-stone-700"><strong class="inline-block w-28 text-stone-900">Phone:</strong> {{ $account->phone_number }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200 shadow-lg shadow-stone-200/50 p-6 flex flex-col items-center gap-4">
            @if($account->profile_photo_url)
                <img src="{{ asset($account->profile_photo_url) }}" alt="Profile Photo" class="w-32 h-32 rounded-full object-cover border-2 border-amber-400 shadow-md">
            @else
                <div class="w-32 h-32 rounded-full bg-stone-200 flex items-center justify-center text-stone-500 text-3xl">
                    <i class="fa-solid fa-user"></i>
                </div>
            @endif
            <a href="/customer/profile/edit" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600 shadow-md">
                <i class="fa-solid fa-pen"></i> Edit Profile
            </a>
        </div>
    </div>
@else
    <p class="text-stone-600">Profile information not available.</p>
@endif

<p class="mt-6 text-sm">
    <a href="/customer/index" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors"><i class="fa-solid fa-arrow-left text-xs"></i> Back to Customer Home</a>
</p>
@endsection
