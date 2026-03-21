@extends('layouts.customer')

@section('title', 'Shop - Categories')

@section('content')
<div class="flex flex-wrap items-center gap-3 mb-6">
    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
        <i class="fa-solid fa-tags text-amber-600 text-xl"></i>
    </div>
    <div class="flex-1">
        <h2 class="text-xl font-bold text-stone-900">Shop by category</h2>
        <p class="text-stone-500 text-sm mt-0.5">Choose a category to browse brands and products</p>
    </div>
    <a href="/shop/browse" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 text-white text-sm font-semibold rounded-xl hover:bg-amber-600 shadow-md shrink-0">
        <i class="fa-solid fa-magnifying-glass"></i> Search &amp; filter
    </a>
</div>

@if($categories->isEmpty())
    <div class="rounded-2xl border border-stone-200 bg-white shadow-lg shadow-stone-200/50 p-12 text-center">
        <div class="w-16 h-16 rounded-full bg-stone-100 flex items-center justify-center mx-auto mb-3">
            <i class="fa-solid fa-tags text-3xl text-stone-400"></i>
        </div>
        <p class="text-stone-600">No categories yet.</p>
        <a href="/customer/index" class="inline-flex items-center gap-2 mt-3 text-amber-600 hover:text-amber-700 font-medium text-sm"><i class="fa-solid fa-arrow-left"></i> Back to Customer Home</a>
    </div>
@else
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($categories as $category)
            <a href="/shop/categories/{{ $category->category_id }}" class="group block rounded-2xl bg-white border border-stone-200 shadow-md shadow-stone-200/50 hover:shadow-xl hover:shadow-amber-500/10 hover:border-amber-300/50 overflow-hidden transition-all duration-200">
                <div class="aspect-square bg-stone-100 relative overflow-hidden">
                    @if($category->photo_url)
                        <img src="{{ asset($category->photo_url) }}" alt="{{ $category->category_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-100 to-stone-200">
                            <i class="fa-solid fa-music text-5xl text-amber-400/70"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-200">
                        <span class="inline-flex items-center gap-1.5 text-white text-sm font-medium">
                            View brands <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-stone-900 group-hover:text-amber-700 transition-colors text-center">{{ $category->category_name }}</h3>
                    <p class="text-center mt-1">
                        <span class="inline-flex items-center gap-1.5 text-amber-600 text-sm font-medium">
                            View brands <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </p>
                </div>
            </a>
        @endforeach
    </div>
@endif

<p class="mt-8"><a href="/customer/index" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors text-sm"><i class="fa-solid fa-arrow-left"></i> Back to Customer Home</a></p>
@endsection
