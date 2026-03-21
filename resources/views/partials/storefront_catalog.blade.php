@php
    $canAddToCart = session()->has('user') && session('user')->role === 'customer';
@endphp

<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
            <i class="fa-solid fa-magnifying-glass text-amber-600 text-xl"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-stone-900">{{ $catalogHeading ?? 'Search & filter' }}</h2>
            <p class="text-stone-500 text-sm mt-0.5">{{ $catalogSubheading ?? 'Find gear by keyword, price, category, brand, or type (model).' }}</p>
        </div>
    </div>
    <a href="/shop" class="inline-flex items-center gap-2 text-sm text-amber-600 hover:text-amber-700 shrink-0"><i class="fa-solid fa-tags"></i> Browse by category</a>
</div>

<form method="get" action="{{ $catalogFormAction }}" class="rounded-2xl border border-stone-200 bg-white shadow-lg shadow-stone-200/50 p-5 mb-8 space-y-4">
    <div>
        <label for="q" class="block text-sm font-medium text-stone-700 mb-1"><i class="fa-solid fa-search text-stone-400 mr-1"></i> Search products / services</label>
        <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Name, description, model, category, or brand…"
            class="w-full rounded-xl border border-stone-300 px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label for="min_price" class="block text-sm font-medium text-stone-700 mb-1">Min price</label>
            <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" step="0.01" min="0" placeholder="0.00"
                class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
        </div>
        <div>
            <label for="max_price" class="block text-sm font-medium text-stone-700 mb-1">Max price</label>
            <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" step="0.01" min="0" placeholder="Any"
                class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
        </div>
        <div>
            <label for="category_id" class="block text-sm font-medium text-stone-700 mb-1">Category</label>
            <select name="category_id" id="category_id" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 bg-white">
                <option value="">All categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" @selected(request('category_id') == $cat->category_id)>{{ $cat->category_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="brand_id" class="block text-sm font-medium text-stone-700 mb-1">Brand</label>
            <select name="brand_id" id="brand_id" class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 bg-white">
                <option value="">All brands</option>
                @foreach($brands as $b)
                    <option value="{{ $b->brand_id }}" @selected(request('brand_id') == $b->brand_id)>{{ $b->brand_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="max-w-md">
        <label for="type" class="block text-sm font-medium text-stone-700 mb-1">Type / model</label>
        <input type="text" name="type" id="type" value="{{ request('type') }}" list="type-models" placeholder="e.g. Stratocaster, acoustic…"
            class="w-full rounded-xl border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
        <datalist id="type-models">
            @foreach($typeOptions as $m)
                <option value="{{ $m }}">
            @endforeach
        </datalist>
    </div>

    <div class="flex flex-wrap gap-3 pt-2">
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 shadow-lg shadow-amber-500/20">
            <i class="fa-solid fa-filter"></i> Apply filters
        </button>
        <a href="{{ $catalogClearUrl }}" class="inline-flex items-center gap-2 px-5 py-2.5 border border-stone-300 text-stone-700 font-medium rounded-xl hover:bg-stone-50">
            Clear all
        </a>
    </div>
</form>

@if(request()->hasAny(['q','min_price','max_price','category_id','brand_id','type']))
    <p class="text-stone-600 text-sm mb-4">{{ $products->count() }} result{{ $products->count() !== 1 ? 's' : '' }}</p>
@endif

@if($products->isEmpty())
    <div class="rounded-2xl border border-stone-200 bg-white shadow-lg shadow-stone-200/50 p-12 text-center">
        <div class="w-16 h-16 rounded-full bg-stone-100 flex items-center justify-center mx-auto mb-3">
            <i class="fa-solid fa-box-open text-3xl text-stone-400"></i>
        </div>
        <p class="text-stone-600">No products match your filters.</p>
        <p class="text-stone-500 text-sm mt-2">Try adjusting price range or clearing search.</p>
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
                </a>
                <div class="p-4">
                    <a href="/shop/products/{{ $product->product_id }}" class="font-semibold text-stone-900 hover:text-amber-700 transition-colors block mb-1 min-h-[2.5rem]" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="{{ $product->product_name }}">{{ $product->product_name }}</a>
                    @if($product->brand_name || $product->category_name)
                        <p class="text-xs text-stone-500 mb-1">{{ $product->brand_name }} @if($product->category_name) · {{ $product->category_name }} @endif</p>
                    @endif
                    <p class="text-amber-700 font-bold text-lg mb-3">{{ number_format($product->retail_price, 2) }}</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="/shop/products/{{ $product->product_id }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-stone-200 text-stone-700 text-sm font-medium hover:bg-stone-300 transition-colors">
                            <i class="fa-solid fa-eye"></i> View
                        </a>
                        @if($canAddToCart)
                            <form action="/cart/add/{{ $product->product_id }}" method="post" class="inline">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-amber-500 text-white text-sm font-medium hover:bg-amber-600 transition-colors shadow-sm">
                                    <i class="fa-solid fa-cart-plus"></i> Add
                                </button>
                            </form>
                        @else
                            <a href="/login" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-amber-500/90 text-white text-sm font-medium hover:bg-amber-600 transition-colors shadow-sm">
                                <i class="fa-solid fa-cart-plus"></i> Add
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@if(!empty($showCustomerBackLink) && session()->has('user') && session('user')->role === 'customer')
    <p class="mt-8"><a href="/customer/index" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors text-sm"><i class="fa-solid fa-arrow-left"></i> Back to Customer Home</a></p>
@endif
