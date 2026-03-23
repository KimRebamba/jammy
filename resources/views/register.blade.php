@extends('layouts.customer')

@section('title', 'Register')

@section('content')
<div class="max-w-lg mx-auto">
	<div class="mb-6 text-center">
		<h1 class="text-2xl font-bold text-stone-900">Create your Jammy account</h1>
		<p class="text-stone-500 text-sm mt-1">Sign up to place orders, leave reviews, and track your gear.</p>
	</div>

	@if(session('error'))
		<p class="text-sm text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2 mb-3 flex items-center gap-2">
			<i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
		</p>
	@endif

	@if ($errors->any())
		<ul class="text-sm text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2 mb-4 space-y-1">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	@endif

	<form method="POST" action="/register" enctype="multipart/form-data" class="rounded-2xl border border-stone-200 bg-white shadow-lg shadow-stone-200/50 p-6 space-y-4">
		@csrf

		<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
			<div>
				<label class="block text-sm font-medium text-stone-700 mb-1">Username</label>
				<input type="text" name="username" value="{{ old('username') }}" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
			</div>
			<div>
				<label class="block text-sm font-medium text-stone-700 mb-1">Email</label>
				<input type="text" name="email" value="{{ old('email') }}" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
			</div>
		</div>

		<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
			<div>
				<label class="block text-sm font-medium text-stone-700 mb-1">Password</label>
				<input type="text" name="password" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
			</div>
			<div>
				<label class="block text-sm font-medium text-stone-700 mb-1">Confirm Password</label>
				<input type="text" name="password_confirmation" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
			</div>
		</div>

		<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
			<div>
				<label class="block text-sm font-medium text-stone-700 mb-1">First Name</label>
				<input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
			</div>
			<div>
				<label class="block text-sm font-medium text-stone-700 mb-1">Last Name</label>
				<input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
			</div>
		</div>

		<div>
			<label class="block text-sm font-medium text-stone-700 mb-1">Address</label>
			<input type="text" name="address" value="{{ old('address') }}" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
		</div>

		<div>
			<label class="block text-sm font-medium text-stone-700 mb-1">Phone</label>
			<input type="text" name="phone_number" value="{{ old('phone_number') }}" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
		</div>

		<div>
			<label class="block text-sm font-medium text-stone-700 mb-1">Profile Photo</label>
			<input type="file" name="profile_photo" class="block w-full text-sm text-stone-700 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
		</div>

		<button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 shadow-md shadow-amber-500/25">
			<i class="fa-solid fa-user-plus"></i> Register
		</button>
	</form>

	<p class="mt-4 text-sm text-stone-600 text-center">
		Already have an account?
		<a href="/login" class="text-amber-600 hover:text-amber-700 font-medium">Log in</a>
	</p>
</div>
@endsection
