@extends('layouts.admin')

@section('title', 'Replace Product Photo')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-slate-50">Replace Product Photo</h1>
            <a href="/admin/products/{{ $product->product_id }}/edit" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Edit Product
            </a>
        </div>

        @if ($errors->any())
            <ul class="mb-2 text-sm text-red-300 list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div>
            <h3 class="text-sm font-semibold text-slate-200 mb-2">Current Photo</h3>
            <img src="{{ asset($photo->photo_url) }}" width="220" class="rounded-xl border border-slate-700/80 shadow-md">
        </div>

        <form action="/admin/products/{{ $product->product_id }}/photos/{{ $photo->product_photo_id }}/replace" method="post" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <p class="space-y-1">
                <label class="block text-sm text-slate-200">New Photo:</label>
                <input type="file" name="photo_file" class="mt-1 block w-full text-sm text-slate-200">
            </p>
            <p>
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition-colors">
                    Replace Photo
                </button>
            </p>
        </form>
    </div>
</div>
@endsection
