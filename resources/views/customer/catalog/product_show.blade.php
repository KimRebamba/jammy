@extends('layouts.customer')

@section('title', 'Product Details')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
        <i class="fa-solid fa-box text-amber-600 text-xl"></i>
    </div>
    <h2 class="text-xl font-bold text-stone-900">{{ $product->product_name }}</h2>
</div>

<div class="flex flex-col lg:flex-row gap-8">
    @if(count($photos) > 0)
        <div class="shrink-0">
            <div id="productPhotosCarousel" class="relative">
                <div class="rounded-2xl border-2 border-stone-200 shadow-xl overflow-hidden bg-stone-900/5">
                    @foreach($photos as $index => $photo)
                        <div class="carousel-item {{ $index === 0 ? '' : 'hidden' }} flex items-center justify-center">
                            <img src="{{ asset($photo->photo_url) }}" 
                                 alt="{{ $product->product_name }}" 
                                 class="w-full max-w-md h-80 object-cover mx-auto">
                        </div>
                    @endforeach
                </div>
                @if(count($photos) > 1)
                    <button type="button" class="carousel-prev absolute left-2 top-1/2 -translate-y-1/2 bg-stone-900/70 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-md hover:bg-stone-900">
                        <span class="sr-only">Previous</span>
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <button type="button" class="carousel-next absolute right-2 top-1/2 -translate-y-1/2 bg-stone-900/70 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-md hover:bg-stone-900">
                        <span class="sr-only">Next</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                @endif
            </div>
        </div>
    @elseif($product->primary_photo)
        <div class="shrink-0">
            <img src="{{ asset($product->primary_photo) }}" 
                 alt="{{ $product->product_name }}" 
                 class="rounded-2xl border-2 border-stone-200 shadow-xl w-full max-w-md h-80 object-cover mx-auto">
        </div>
    @endif
    <div class="flex-1">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-lg shadow-stone-200/50 p-6 space-y-3">
            <p class="text-stone-700"><strong class="text-stone-900 w-24 inline-block"><i class="fa-solid fa-copyright text-amber-500/80 mr-1"></i> Brand:</strong> {{ $product->brand_name }}</p>
            <p class="text-stone-700"><strong class="text-stone-900 w-32 inline-block"><i class="fa-solid fa-tags text-amber-500/80 mr-1"></i> Category:</strong> {{ $product->category_name }}</p>
            <p class="text-stone-700"><strong class="text-stone-900 w-24 inline-block"><i class="fa-solid fa-tags text-amber-500/80 mr-1"></i> Model:</strong> {{ $product->model }}</p>
            <p class="text-stone-700"><strong class="text-stone-900 w-24 inline-block"><i class="fa-solid fa-tag text-amber-500/80 mr-1"></i> Price:</strong> <span class="text-amber-700 font-bold">{{ number_format($product->retail_price, 2) }}</span></p>
            <p class="text-stone-700"><strong class="text-stone-900 w-24 inline-block">Description:</strong> {{ $product->description }}</p>
            <p class="text-stone-700"><strong class="text-stone-900 w-24 inline-block"><i class="fa-solid fa-warehouse text-amber-500/80 mr-1"></i> Stock:</strong> {{ $product->stock_level }}</p>
        </div>
        @if(session('user') && session('user')->role === 'customer')
            <form action="/cart/add/{{ $product->product_id }}" method="post" class="mt-4">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 shadow-lg shadow-amber-500/25 transition-all">
                    <i class="fa-solid fa-cart-plus"></i> Add to Cart
                </button>
            </form>
        @else
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <a href="/login" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 shadow-lg shadow-amber-500/25 transition-all">
                    <i class="fa-solid fa-right-to-bracket"></i> Log in to add to cart
                </a>
                <a href="/register" class="inline-flex items-center gap-2 px-5 py-2.5 border border-stone-300 text-stone-800 font-medium rounded-xl hover:bg-stone-50 transition-all text-sm">
                    <i class="fa-solid fa-user-plus"></i> Sign up
                </a>
            </div>
        @endif
    </div>
</div>
@if(isset($reviews) && $reviews->count() > 0)
    <div class="mt-10">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center">
                <i class="fa-solid fa-star text-amber-500"></i>
            </div>
            <h3 class="text-lg font-semibold text-stone-900">Ratings</h3>
        </div>

        <div class="space-y-4">
            @foreach($reviews as $review)            
                <div class="bg-white rounded-2xl border border-stone-200 shadow-sm p-4">
                    <div class="flex items-start justify-between gap-3 mb-1">
                        <div>
                            @if(!empty($review->username))
                                <p class="text-sm font-semibold text-stone-900">{{ '@' . $review->username }}</p>
                            @else
                                <p class="text-sm font-semibold text-stone-900">Verified customer</p>
                            @endif
                            <div class="flex items-center gap-1 mt-1 text-amber-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-amber-500' : 'text-stone-300' }} text-xs"></i>
                                @endfor
                                <span class="ml-2 text-xs text-stone-500">{{ $review->rating }}/5</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-semibold">
                            <i class="fa-solid fa-check-circle"></i> Verified review
                        </span>
                    </div>

                    @if($review->review_title)
                        <p class="text-sm font-semibold text-stone-900 mb-1">{{ $review->review_title }}</p>
                    @endif
                    @if($review->review_text)
                        <p class="text-sm text-stone-700">{{ $review->review_text }}</p>
                    @endif
                        @if($review->created_at)
                            <p class="mt-2 text-xs text-stone-400">Reviewed on {{ \Illuminate\Support\Carbon::parse($review->created_at)->format('M j, Y') }}</p>
                        @endif
                </div>
            @endforeach
        </div>
    </div>
@endif

<p class="mt-8 flex flex-wrap gap-4 text-sm">
    <a href="/shop/categories/{{ $product->category_id }}/brands/{{ $product->brand_id }}" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors"><i class="fa-solid fa-arrow-left"></i> Back to Products</a>
    <a href="/shop" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors">Back to Categories</a>
    <a href="/" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors">Store home</a>
    @if(session('user') && session('user')->role === 'customer')
        <a href="/customer/index" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors">Dashboard</a>
    @endif
</p>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carousel = document.getElementById('productPhotosCarousel');
        if (!carousel) return;

        const items = carousel.querySelectorAll('.carousel-item');
        if (items.length === 0) return;

        let currentIndex = 0;

        function showSlide(index) {
            items[currentIndex].classList.add('hidden');
            currentIndex = (index + items.length) % items.length;
            items[currentIndex].classList.remove('hidden');
        }

        const prevBtn = carousel.querySelector('.carousel-prev');
        const nextBtn = carousel.querySelector('.carousel-next');

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                showSlide(currentIndex - 1);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                showSlide(currentIndex + 1);
            });
        }
    });
</script>
@endsection
