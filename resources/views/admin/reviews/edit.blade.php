@extends('layouts.admin')

@section('title', 'Edit Review Verification')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Edit Review Verification</h1>
            <a href="/admin/reviews" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                Back to Reviews
            </a>
        </div>

        @if($errors->any())
            <ul class="mb-4 text-sm text-red-300 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="/admin/reviews/{{ $review->review_id }}/update" method="post" class="space-y-4">
            @csrf
            <div class="flex items-center gap-3">
                <input id="is_verified" type="checkbox" name="is_verified" value="1" class="h-4 w-4 rounded border-slate-600 bg-slate-900 text-amber-500 focus:ring-amber-500" {{ old('is_verified', $review->is_verified) ? 'checked' : '' }}>
                <label for="is_verified" class="text-sm text-slate-100">Mark this review as verified</label>
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition-colors">
                Save Changes
            </button>
        </form>
    </div>
</div>
@endsection
