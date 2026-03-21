@extends('layouts.customer')

@section('title', 'Shop - Brands')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
        <i class="fa-solid fa-copyright text-amber-600 text-xl"></i>
    </div>
    <h2 class="text-xl font-bold text-stone-900">Brands for {{ $category->category_name }}</h2>
</div>

<div class="overflow-x-auto rounded-2xl border border-stone-200 bg-white shadow-lg shadow-stone-200/50">
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gradient-to-r from-stone-100 to-stone-50">
                <th class="p-4 text-left text-sm font-semibold text-stone-700"><i class="fa-solid fa-image text-stone-400 mr-2"></i>Logo</th>
                <th class="p-4 text-left text-sm font-semibold text-stone-700">Brand</th>
                <th class="p-4 text-left text-sm font-semibold text-stone-700">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
                <tr class="border-t border-stone-100 hover:bg-amber-50/30 transition-colors">
                    <td class="p-4">
                        @if($brand->logo_url)
                            <img src="{{ asset($brand->logo_url) }}" alt="{{ $brand->brand_name }}" width="80" class="rounded-lg border border-stone-200 shadow-sm">
                        @else
                            <span class="text-stone-400 text-sm">—</span>
                        @endif
                    </td>
                    <td class="p-4 font-medium text-stone-900">{{ $brand->brand_name }}</td>
                    <td class="p-4">
                        <a href="/shop/categories/{{ $category->category_id }}/brands/{{ $brand->brand_id }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-500 text-white text-sm font-medium rounded-lg hover:bg-amber-600 transition-colors shadow-sm">
                            <i class="fa-solid fa-arrow-right"></i> View Products
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<p class="mt-5 flex flex-wrap gap-4 text-sm">
    <a href="/shop" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors"><i class="fa-solid fa-arrow-left"></i> Back to Categories</a>
    <a href="/customer/index" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors">Back to Customer Home</a>
</p>
@endsection
