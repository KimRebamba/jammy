@extends('layouts.customer')

@section('title', 'Jammy Music')

@section('content')
    <div class="rounded-2xl border border-stone-200 bg-white/90 shadow-lg shadow-stone-200/50 p-6 sm:p-8 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-stone-900">Welcome to Jammy Music</h1>
                <p class="text-stone-600 mt-1">
                    @if(session('user'))
                        Hello, <span class="font-semibold text-stone-800">{{ session('user')->username }}</span> — browse below or head to your <a href="/customer/index" class="text-amber-600 hover:underline">dashboard</a>.
                    @else
                        Browse our catalog below. <span class="text-stone-500">Log in</span> to add items to your cart and checkout.
                    @endif
                </p>
            </div>
            @if(!session('user'))
                <div class="flex flex-wrap gap-2">
                    <a href="/login" class="inline-flex items-center gap-2 py-2.5 px-4 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 shadow-md shadow-amber-500/20 text-sm">
                        <i class="fa-solid fa-right-to-bracket"></i> Log in
                    </a>
                    <a href="/register" class="inline-flex items-center gap-2 py-2.5 px-4 border border-stone-300 text-stone-800 font-medium rounded-xl hover:bg-stone-50 text-sm">
                        <i class="fa-solid fa-user-plus"></i> Sign up
                    </a>
                </div>
            @endif
        </div>
    </div>

    @include('partials.storefront_catalog', [
        'catalogHeading' => 'Shop',
        'catalogSubheading' => 'Search and filter products the same way as in the store — no account needed to browse.',
        'catalogFormAction' => url('/home'),
        'catalogClearUrl' => url('/home'),
        'showCustomerBackLink' => false,
    ])
@endsection