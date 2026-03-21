@extends('layouts.customer')

@section('title', 'Shop - Products')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
        <i class="fa-solid fa-box text-amber-600 text-xl"></i>
    </div>
    <div>
        <h2 class="text-xl font-bold text-stone-900">Products for {{ $brand->brand_name }} in {{ $category->category_name }}</h2>
        <p class="text-stone-500 text-sm mt-0.5">{{ $products->count() }} product{{ $products->count() !== 1 ? 's' : '' }}</p>
    </div>
</div>

<form method="get" action="{{ url()->current() }}" class="rounded-2xl border border-stone-200 bg-white shadow-md shadow-stone-200/50 p-4 mb-6 space-y-4">
    <p class="text-xs text-stone-500">Category and brand are fixed above; narrow by keyword, type (model), and price.</p>
    <div class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[180px]">
            <label for="q" class="block text-xs font-medium text-stone-600 mb-1">Search</label>
            <input type="search" name="q" id="q" value="{{ request('q') }}" placeholder="Name, description, model…"
                class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20">
        </div>
        <div class="w-full sm:w-48">
            <label for="type" class="block text-xs font-medium text-stone-600 mb-1">Type / model</label>
            <input type="text" name="type" id="type" value="{{ request('type') }}" placeholder="e.g. Stratocaster…"
                class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20">
        </div>
        <div>
            <label for="min_price" class="block text-xs font-medium text-stone-600 mb-1">Min price</label>
            <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" step="0.01" min="0" placeholder="0"
                class="w-32 rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20">
        </div>
        <div>
            <label for="max_price" class="block text-xs font-medium text-stone-600 mb-1">Max price</label>
            <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" step="0.01" min="0" placeholder="Any"
                class="w-32 rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20">
        </div>
        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 text-white text-sm font-medium rounded-lg hover:bg-amber-600 transition-colors">
            <i class="fa-solid fa-filter"></i> Apply
        </button>
        @if(request()->hasAny(['q', 'type', 'min_price', 'max_price']))
            <a href="{{ url()->current() }}" class="text-sm text-stone-600 hover:text-amber-600 self-end pb-2">Clear filters</a>
        @endif
    </div>
</form>

@if($products->isEmpty())
    <div class="rounded-2xl border border-stone-200 bg-white shadow-lg shadow-stone-200/50 p-12 text-center">
        <div class="w-16 h-16 rounded-full bg-stone-100 flex items-center justify-center mx-auto mb-3">
            <i class="fa-solid fa-box-open text-3xl text-stone-400"></i>
        </div>
        <p class="text-stone-600">No products in this category yet.</p>
        <a href="/shop/categories/{{ $category->category_id }}" class="inline-flex items-center gap-2 mt-3 text-amber-600 hover:text-amber-700 font-medium text-sm"><i class="fa-solid fa-arrow-left"></i> Back to Brands</a>
    </div>
@else
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($products as $product)
            <div class="group rounded-2xl bg-white border border-stone-200 shadow-md shadow-stone-200/50 hover:shadow-xl hover:shadow-amber-500/10 hover:border-amber-300/50 overflow-hidden transition-all duration-200">
                <a href="/shop/products/{{ $product->product_id }}" class="block aspect-square bg-stone-100 relative overflow-hidden">
                    @if($product->photo_url)
                        <img src="{{ asset($product->photo_url) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fa-solid fa-music text-5xl text-stone-300"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>
                <div class="p-4">
                    <a href="/shop/products/{{ $product->product_id }}" class="font-semibold text-stone-900 hover:text-amber-700 transition-colors block mb-2 min-h-[2.5rem]" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="{{ $product->product_name }}">{{ $product->product_name }}</a>
                    <p class="text-amber-700 font-bold text-lg mb-3">{{ number_format($product->retail_price, 2) }}</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="/shop/products/{{ $product->product_id }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-stone-200 text-stone-700 text-sm font-medium hover:bg-stone-300 transition-colors">
                            <i class="fa-solid fa-eye"></i> View
                        </a>
                        <form action="/cart/add/{{ $product->product_id }}" method="post" class="inline">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-amber-500 text-white text-sm font-medium hover:bg-amber-600 transition-colors shadow-sm">
                                <i class="fa-solid fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<p class="mt-8 flex flex-wrap gap-4 text-sm">
    <a href="/shop/categories/{{ $category->category_id }}" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors"><i class="fa-solid fa-arrow-left"></i> Back to Brands</a>
    <a href="/shop" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors">Back to Categories</a>
    @if(session('user') && session('user')->role === 'customer')
        <a href="/customer/index" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors">Dashboard</a>
    @endif
</p>
@endsection
