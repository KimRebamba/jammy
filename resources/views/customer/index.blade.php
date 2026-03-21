@extends('layouts.customer')

@section('title', 'Customer Home')

@section('content')
{{-- Hero / Welcome --}}
<div class="rounded-2xl bg-gradient-to-br from-stone-800 to-stone-900 text-white p-8 sm:p-10 mb-8 shadow-xl border border-amber-500/20 overflow-hidden relative">
    <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="relative">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-14 h-14 rounded-xl bg-amber-500/30 flex items-center justify-center">
                <i class="fa-solid fa-house text-amber-400 text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white">Welcome back</h1>
                @if(session('user'))
                    <p class="text-amber-200/90 text-lg">{{ session('user')->username }}</p>
                @else
                    <p class="text-stone-300">Explore our gear</p>
                @endif
            </div>
        </div>
        <p class="text-stone-300 text-sm sm:text-base mt-1">Your stage starts here. Guitars, amps, drums & more.</p>
    </div>
</div>

{{-- Quick links --}}
<div class="grid grid-cols-2 sm:flex sm:flex-wrap gap-3 mb-10">
    <a href="/customer/profile" class="flex items-center gap-3 rounded-xl bg-white border border-stone-200 shadow-md shadow-stone-200/50 hover:shadow-lg hover:border-amber-300/50 p-4 transition-all group">
        <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center group-hover:bg-amber-500/30 shrink-0">
            <i class="fa-solid fa-user text-amber-600"></i>
        </div>
        <span class="font-medium text-stone-800 group-hover:text-amber-800">Profile</span>
    </a>
    <a href="/shop" class="flex items-center gap-3 rounded-xl bg-white border border-stone-200 shadow-md shadow-stone-200/50 hover:shadow-lg hover:border-amber-300/50 p-4 transition-all group">
        <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center group-hover:bg-amber-500/30 shrink-0">
            <i class="fa-solid fa-shop text-amber-600"></i>
        </div>
        <span class="font-medium text-stone-800 group-hover:text-amber-800">Products</span>
    </a>
    <a href="/orders" class="flex items-center gap-3 rounded-xl bg-white border border-stone-200 shadow-md shadow-stone-200/50 hover:shadow-lg hover:border-amber-300/50 p-4 transition-all group">
        <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center group-hover:bg-amber-500/30 shrink-0">
            <i class="fa-solid fa-box-open text-amber-600"></i>
        </div>
        <span class="font-medium text-stone-800 group-hover:text-amber-800">Orders</span>
    </a>
    <a href="/reviews" class="flex items-center gap-3 rounded-xl bg-white border border-stone-200 shadow-md shadow-stone-200/50 hover:shadow-lg hover:border-amber-300/50 p-4 transition-all group">
        <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center group-hover:bg-amber-500/30 shrink-0">
            <i class="fa-solid fa-star text-amber-600"></i>
        </div>
        <span class="font-medium text-stone-800 group-hover:text-amber-800">Reviews</span>
    </a>
    <a href="/cart" class="flex items-center gap-3 rounded-xl bg-white border border-stone-200 shadow-md shadow-stone-200/50 hover:shadow-lg hover:border-amber-300/50 p-4 transition-all group">
        <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center group-hover:bg-amber-500/30 shrink-0">
            <i class="fa-solid fa-cart-shopping text-amber-600"></i>
        </div>
        <span class="font-medium text-stone-800 group-hover:text-amber-800">Cart</span>
    </a>
</div>

{{-- Footer links --}}
<div class="pt-4 border-t border-stone-200 flex flex-wrap gap-4 text-sm">
    <a href="/home" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors"><i class="fa-solid fa-arrow-left"></i> Back to Home</a>
    <a href="/logout" class="inline-flex items-center gap-1.5 text-stone-500 hover:text-amber-600 transition-colors"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>
@endsection
