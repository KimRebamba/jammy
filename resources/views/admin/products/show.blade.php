@extends('layouts.admin')

@section('title', 'View Product')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6 flex flex-col md:flex-row gap-6">
        <div class="md:w-1/3 flex justify-center items-start">
            @if($product->primary_photo)
                <img src="{{ asset($product->primary_photo) }}" width="220" class="rounded-xl border border-slate-700/80 shadow-md">
            @else
                <div class="w-40 h-40 rounded-xl border border-dashed border-slate-700 flex items-center justify-center text-slate-500 text-sm">
                    No primary photo
                </div>
            @endif
        </div>
        <div class="md:w-2/3 space-y-2">
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-xl font-semibold text-slate-50">Product Details</h1>
                <a href="/admin/products/{{ $product->product_id }}/edit" class="text-sm px-3 py-1.5 rounded-lg bg-amber-500 text-slate-900 font-semibold hover:bg-amber-400 transition-colors">Edit</a>
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                <div>
                    <dt class="text-slate-400">ID</dt>
                    <dd class="text-slate-100">{{ $product->product_id }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Name</dt>
                    <dd class="text-slate-100">{{ $product->product_name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Brand</dt>
                    <dd class="text-slate-100">{{ $product->brand_name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Category</dt>
                    <dd class="text-slate-100">{{ $product->category_name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Model</dt>
                    <dd class="text-slate-100">{{ $product->model }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Retail Price</dt>
                    <dd class="text-slate-100">{{ $product->retail_price }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Cost Price</dt>
                    <dd class="text-slate-100">{{ $product->cost_price }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Stock Level</dt>
                    <dd class="text-slate-100">{{ $product->stock_level }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-slate-400">Description</dt>
                    <dd class="text-slate-100">{{ $product->description }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Active</dt>
                    <dd class="text-slate-100">{{ $product->is_active ? 'Yes' : 'No' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-slate-50">All Photos</h2>
            <a href="/admin/products" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Products
            </a>
        </div>
        @if(count($photos) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-slate-800/80">
                    <thead class="bg-slate-800/80 text-slate-200">
                        <tr>
                            <th class="px-3 py-2 border-b border-slate-700/80">Image</th>
                            <th class="px-3 py-2 border-b border-slate-700/80">Primary</th>
                            <th class="px-3 py-2 border-b border-slate-700/80">Sort Order</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        @foreach($photos as $photo)
                            <tr>
                                <td class="px-3 py-2"><img src="{{ asset($photo->photo_url) }}" width="100" class="rounded-lg border border-slate-700/80"></td>
                                <td class="px-3 py-2">{{ $photo->is_primary ? 'Yes' : 'No' }}</td>
                                <td class="px-3 py-2">{{ $photo->sort_order }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-slate-300">No additional photos.</p>
        @endif
    </div>
</div>
@endsection
