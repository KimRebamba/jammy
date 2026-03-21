@extends('layouts.customer')

@section('title', 'My Reviews')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
        <i class="fa-solid fa-star text-amber-500 text-xl"></i>
    </div>
    <h2 class="text-xl font-bold text-stone-900">My Reviews</h2>
</div>

@if($reviews->isEmpty())
    <div class="rounded-2xl border border-dashed border-stone-300 bg-white/60 p-6 text-center text-stone-600">
        <p class="font-medium mb-2">You haven&apos;t written any reviews yet.</p>
        <p class="text-sm">Review your past orders to help other musicians.</p>
        <a href="/orders" class="inline-flex items-center gap-2 px-4 py-2 mt-3 rounded-xl bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600 shadow-sm">
            <i class="fa-solid fa-box-open"></i> View my orders
        </a>
    </div>
@else
    <div class="bg-white rounded-2xl border border-stone-200 shadow-lg shadow-stone-200/50">
        <div class="overflow-x-auto rounded-2xl">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gradient-to-r from-stone-100 to-stone-50">
                    <tr class="text-left text-stone-600">
                        <th class="px-4 py-3 font-semibold">Product</th>
                        <th class="px-4 py-3 font-semibold">Rating</th>
                        <th class="px-4 py-3 font-semibold">Title</th>
                        <th class="px-4 py-3 font-semibold">Review</th>
                        <th class="px-4 py-3 font-semibold">Verified</th>
                        <th class="px-4 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr class="border-t border-stone-100 hover:bg-stone-50/60">
                            <td class="px-4 py-3 text-stone-900 font-medium">{{ $review->product_name }}</td>
                            <td class="px-4 py-3 text-stone-700">{{ $review->rating }}</td>
                            <td class="px-4 py-3 text-stone-700">{{ $review->review_title }}</td>
                            <td class="px-4 py-3 text-stone-700 max-w-xs">
                                {{ \Illuminate\Support\Str::limit($review->review_text, 80) }}
                            </td>
                            <td class="px-4 py-3 text-stone-700">
                                @if($review->is_verified)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold"><i class="fa-solid fa-check-circle"></i> Verified</span>
                                @else
                                    <span class="text-xs text-stone-500">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right text-xs">
                                <div class="inline-flex items-center gap-3 justify-end">
                                    <a href="/reviews/{{ $review->review_id }}/edit" class="text-amber-600 hover:text-amber-700 font-medium">Edit</a>
                                    <form action="/reviews/{{ $review->review_id }}/delete" method="post" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-500 hover:text-red-600">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<p class="mt-4 text-sm">
    <a href="/customer/index" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors"><i class="fa-solid fa-arrow-left text-xs"></i> Back to Customer Home</a>
</p>
@endsection
