@extends('layouts.customer')

@section('title', 'Create Review')

@section('content')
<h2 class="text-xl font-semibold text-stone-900 mb-4">Create Review for Order #{{ $order->order_id }}</h2>

@if($errors->any())
    <ul class="text-sm text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2 mb-4">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="rounded-lg border border-stone-200 bg-white shadow-sm p-6 max-w-lg">
    <form action="/orders/{{ $order->order_id }}/review" method="post" class="space-y-4">
        @csrf
        <div>
            <label for="product_order_id" class="block text-sm font-medium text-stone-700 mb-1">Product</label>
            <select name="product_order_id" id="product_order_id" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                @foreach($items as $item)
                    <option value="{{ $item->product_order_id }}" @if(old('product_order_id') == $item->product_order_id) selected @endif>
                        {{ $item->product_name }} x{{ $item->quantity }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="rating" class="block text-sm font-medium text-stone-700 mb-1">Rating (1-5)</label>
            <input type="text" name="rating" id="rating" value="{{ old('rating') }}" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
        </div>
        <div>
            <label for="review_title" class="block text-sm font-medium text-stone-700 mb-1">Title</label>
            <input type="text" name="review_title" id="review_title" value="{{ old('review_title') }}" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
        </div>
        <div>
            <label for="review_text" class="block text-sm font-medium text-stone-700 mb-1">Review</label>
            <textarea name="review_text" id="review_text" rows="4" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">{{ old('review_text') }}</textarea>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition-colors">Save Review</button>
    </form>
</div>

<p class="mt-4 space-x-4 text-sm">
    <a href="/orders" class="text-amber-600 hover:text-amber-700 transition-colors">Back to Orders</a>
    <a href="/customer/index" class="text-amber-600 hover:text-amber-700 transition-colors">Back to Customer Home</a>
</p>
@endsection
