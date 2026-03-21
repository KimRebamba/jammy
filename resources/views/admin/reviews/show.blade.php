@extends('layouts.admin')

@section('title', 'Review Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Review Details</h1>
            <div class="flex items-center gap-3">
                <a href="/admin/reviews/{{ $review->review_id }}/edit" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-800 text-xs font-semibold text-slate-100 hover:bg-slate-700 transition-colors">Edit</a>
                <a href="/admin/reviews" class="text-xs text-amber-400 hover:text-amber-300 transition-colors">Back to Reviews</a>
            </div>
        </div>

        <dl class="divide-y divide-slate-800 text-sm">
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">ID</dt>
                <dd class="text-slate-50 font-medium">{{ $review->review_id }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Customer</dt>
                <dd class="text-slate-100">{{ $review->username }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Product</dt>
                <dd class="text-slate-100">{{ $review->product_name }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Rating</dt>
                <dd class="text-slate-50 font-medium">{{ $review->rating }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Title</dt>
                <dd class="text-slate-100 max-w-sm text-right">{{ $review->review_title }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Text</dt>
                <dd class="text-slate-100 max-w-sm text-right">{{ $review->review_text }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Verified</dt>
                <dd class="text-slate-50 font-medium">{{ $review->is_verified ? 'Yes' : 'No' }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection
