@extends('layouts.customer')

@section('title', 'Edit Profile')

@section('content')
<h2 class="text-xl font-semibold text-stone-900 mb-4">Edit Profile</h2>

@if($errors->any())
    <ul class="text-sm text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2 mb-4">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@if($account)
    <p class="text-stone-700 mb-2"><strong class="text-stone-900">Username:</strong> {{ $account->username }}</p>
    <p class="text-stone-700 mb-4"><strong class="text-stone-900">Email:</strong> {{ $account->email }}</p>

    <div class="rounded-lg border border-stone-200 bg-white shadow-sm p-6 max-w-lg">
        <form action="/customer/profile/update" method="post" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="first_name" class="block text-sm font-medium text-stone-700 mb-1">First Name</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $account->first_name) }}" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-stone-700 mb-1">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $account->last_name) }}" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-stone-700 mb-1">Address</label>
                <input type="text" name="address" id="address" value="{{ old('address', $account->address) }}" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
            </div>
            <div>
                <label for="phone_number" class="block text-sm font-medium text-stone-700 mb-1">Phone</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $account->phone_number) }}" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
            </div>
            <div>
                <label for="profile_photo" class="block text-sm font-medium text-stone-700 mb-1">Profile Photo</label>
                <input type="file" name="profile_photo" id="profile_photo" class="block w-full text-sm text-stone-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition-colors">Save</button>
        </form>
    </div>

    <p class="mt-4 space-x-4 text-sm">
        <a href="/customer/profile" class="text-amber-600 hover:text-amber-700 transition-colors">Back to Profile</a>
        <a href="/customer/index" class="text-amber-600 hover:text-amber-700 transition-colors">Back to Customer Home</a>
    </p>
@endif
@endsection
