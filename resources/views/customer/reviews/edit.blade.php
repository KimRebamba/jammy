@extends('layouts.customer')

@section('title', 'Edit Review')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
        <i class="fa-solid fa-star-half-stroke text-amber-500 text-xl"></i>
    </div>
    <h2 class="text-xl font-bold text-stone-900">Edit Review for {{ $review->product_name }}</h2>
</div>

@if ($errors->any())
    <ul class="text-sm text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2 mb-4 list-disc list-inside">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="rounded-2xl border border-stone-200 bg-white shadow-lg shadow-stone-200/50 p-6 max-w-lg">
    <form action="/reviews/{{ $review->review_id }}/update" method="post" class="space-y-4">
        @csrf
        <div>
            <label for="rating" class="block text-sm font-medium text-stone-700 mb-1">Rating (1-5)</label>
            <input type="text" name="rating" id="rating" value="{{ old('rating', $review->rating) }}" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
        </div>
        <div>
            <label for="review_title" class="block text-sm font-medium text-stone-700 mb-1">Title</label>
            <input type="text" name="review_title" id="review_title" value="{{ old('review_title', $review->review_title) }}" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
        </div>
        <div>
            <label for="review_text" class="block text-sm font-medium text-stone-700 mb-1">Review</label>
            <textarea name="review_text" id="review_text" rows="4" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">{{ old('review_text', $review->review_text) }}</textarea>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition-colors">Save</button>
    </form>
</div>

<p class="mt-4 text-sm">
    <a href="/reviews" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors"><i class="fa-solid fa-arrow-left text-xs"></i> Back to Reviews</a>
</p>
@endsection
