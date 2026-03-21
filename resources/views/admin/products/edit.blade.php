@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Edit Product</h1>
            <a href="/admin/products" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Products
            </a>
        </div>

        @if($errors->any())
            <ul class="mb-4 text-sm text-red-300 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="/admin/products/{{ $product->product_id }}/update" method="post" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <p>Name: <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Brand:
                <select name="brand_id" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="">-- none --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->brand_id }}" {{ old('brand_id', $product->brand_id) == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
            </p>
            <p>Category:
                <select name="category_id" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="">-- none --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </p>
            <p>Model: <input type="text" name="model" value="{{ old('model', $product->model) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Retail Price: <input type="text" name="retail_price" value="{{ old('retail_price', $product->retail_price) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Cost Price: <input type="text" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Description:<br>
                <textarea name="description" rows="4" cols="50" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">{{ old('description', $product->description) }}</textarea>
            </p>
            <p>Stock Level: <input type="text" name="stock_level" value="{{ old('stock_level', $product->stock_level) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Primary Photo (800x800):
                <input type="file" name="photo_url" class="mt-1 block w-full text-sm text-slate-200">
            </p>
            <p>Additional Photos (800x800):
                <input type="file" name="additional_photos[]" multiple class="mt-1 block w-full text-sm text-slate-200">
            </p>
            <p class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded border-slate-600 bg-slate-900">
                <span>Active</span>
            </p>

            <p>
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition-colors">
                    Save Changes
                </button>
            </p>
        </form>
    </div>

    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <h2 class="text-lg font-semibold text-slate-50 mb-4">Existing Photos</h2>
        @if(count($photos) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-slate-800/80">
                    <thead class="bg-slate-800/80 text-slate-200">
                        <tr>
                            <th class="px-3 py-2 border-b border-slate-700/80">Image</th>
                            <th class="px-3 py-2 border-b border-slate-700/80">Primary</th>
                            <th class="px-3 py-2 border-b border-slate-700/80">Sort Order</th>
                            <th class="px-3 py-2 border-b border-slate-700/80">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        @foreach($photos as $photo)
                            <tr>
                                <td class="px-3 py-2"><img src="{{ asset($photo->photo_url) }}" width="80" class="rounded-lg border border-slate-700/80"></td>
                                <td class="px-3 py-2">{{ $photo->is_primary ? 'Yes' : 'No' }}</td>
                                <td class="px-3 py-2">{{ $photo->sort_order }}</td>
                                <td class="px-3 py-2 space-x-2">
                                    <form action="/admin/products/{{ $product->product_id }}/photos/{{ $photo->product_photo_id }}/delete" method="post" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs px-3 py-1 rounded bg-red-500/80 hover:bg-red-400 text-slate-950 font-semibold">Delete</button>
                                    </form>
                                    <a href="/admin/products/{{ $product->product_id }}/photos/{{ $photo->product_photo_id }}/replace" class="text-xs px-3 py-1 rounded bg-slate-700 hover:bg-slate-600 text-slate-50 font-semibold inline-block mt-1 sm:mt-0">Replace</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-slate-300">No photos for this product yet.</p>
        @endif
    </div>
</div>
@endsection
