@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Add Product</h1>
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

        <form action="/admin/products" method="post" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <p>Name: <input type="text" name="product_name" value="{{ old('product_name') }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Brand:
                <select name="brand_id" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="">-- none --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->brand_id }}" {{ old('brand_id') == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
            </p>
            <p>Category:
                <select name="category_id" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="">-- none --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </p>
            <p>Model: <input type="text" name="model" value="{{ old('model') }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Retail Price: <input type="text" name="retail_price" value="{{ old('retail_price') }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Cost Price: <input type="text" name="cost_price" value="{{ old('cost_price') }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Description:<br>
                <textarea name="description" rows="4" cols="50" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">{{ old('description') }}</textarea>
            </p>
            <p>Stock Level: <input type="text" name="stock_level" value="{{ old('stock_level') }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Primary Photo (800x800): <input type="file" name="photo_url" class="mt-1 block w-full text-sm text-slate-200"></p>
            <p>Additional Photos (800x800): <input type="file" name="additional_photos[]" multiple class="mt-1 block w-full text-sm text-slate-200"></p>
            <p class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="rounded border-slate-600 bg-slate-900">
                <span>Active</span>
            </p>

            <p>
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition-colors">
                    Save Product
                </button>
            </p>
        </form>
    </div>
</div>
@endsection
