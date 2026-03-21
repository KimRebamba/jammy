@extends('layouts.customer')

@section('title', 'My Cart')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
        <i class="fa-solid fa-cart-shopping text-amber-600 text-xl"></i>
    </div>
    <h2 class="text-xl font-bold text-stone-900">My Cart</h2>
</div>

@if(!$cart || count($items) === 0)
    <div class="rounded-2xl border border-dashed border-stone-300 bg-white/60 p-6 text-center text-stone-600">
        <p class="font-medium mb-2">Your cart is empty.</p>
        <p class="text-sm mb-3">Browse the shop and add some gear to your cart.</p>
        <a href="/shop" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600 shadow-sm">
            <i class="fa-solid fa-shop"></i> Go to shop
        </a>
    </div>
@else
    <form id="buy-form" action="/cart/buy" method="post" class="hidden">
        @csrf
    </form>

    <div class="bg-white rounded-2xl border border-stone-200 shadow-lg shadow-stone-200/50">
        <div class="overflow-x-auto rounded-2xl">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gradient-to-r from-stone-100 to-stone-50">
                    <tr class="text-left text-stone-600">
                        <th class="px-4 py-3 font-semibold"><input type="checkbox" onclick="document.querySelectorAll('.cart-item-checkbox').forEach(cb => cb.checked = this.checked);" aria-label="Select all"></th>
                        <th class="px-4 py-3 font-semibold">Item</th>
                        <th class="px-4 py-3 font-semibold">Price</th>
                        <th class="px-4 py-3 font-semibold">Quantity</th>
                        <th class="px-4 py-3 font-semibold">Subtotal</th>
                        <th class="px-4 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($items as $item)
                        @php $subtotal = $item->quantity * $item->retail_price; $total += $subtotal; @endphp
                        <tr class="border-t border-stone-100 hover:bg-stone-50/60">
                            <td class="px-4 py-3 align-top">
                                <input type="checkbox" name="items[]" value="{{ $item->cart_product_id }}" form="buy-form" class="cart-item-checkbox rounded border-stone-300 text-amber-500 focus:ring-amber-500">
                            </td>
                            <td class="px-4 py-3 flex items-center gap-3">
                                <div class="w-16 h-16 rounded-xl bg-stone-100 overflow-hidden flex items-center justify-center">
                                    @if($item->photo_url)
                                        <img src="{{ asset($item->photo_url) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-music text-2xl text-stone-300"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-stone-900">{{ $item->product_name }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-stone-700">{{ number_format($item->retail_price, 2) }}</td>
                            <td class="px-4 py-3 text-stone-700">
                                <span class="inline-flex items-center gap-2">
                                    <span>{{ $item->quantity }}</span>
                                    <span class="inline-flex items-center gap-1">
                                        <form action="/cart/item/{{ $item->cart_product_id }}/up" method="post" class="inline">
                                            @csrf
                                            <button type="submit" class="w-7 h-7 inline-flex items-center justify-center rounded-full border border-stone-300 text-stone-700 hover:bg-stone-100" title="Increase quantity">
                                                <i class="fa-solid fa-plus text-xs"></i>
                                            </button>
                                        </form>
                                        <form action="/cart/item/{{ $item->cart_product_id }}/down" method="post" class="inline">
                                            @csrf
                                            <button type="submit" class="w-7 h-7 inline-flex items-center justify-center rounded-full border border-stone-300 text-stone-700 hover:bg-stone-100" title="Decrease quantity">
                                                <i class="fa-solid fa-minus text-xs"></i>
                                            </button>
                                        </form>
                                    </span>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-stone-900 font-medium">{{ number_format($subtotal, 2) }}</td>
                            <td class="px-4 py-3 text-right">
                                <form action="/cart/item/{{ $item->cart_product_id }}/delete" method="post" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 text-red-500 hover:text-red-600 text-xs font-medium">
                                        <i class="fa-solid fa-trash"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="border-t border-stone-200 bg-stone-50/80">
                        <td colspan="3" class="px-4 py-3 text-sm text-stone-600">Select the items you want to buy, then click "Buy Selected".</td>
                        <td class="px-4 py-3 text-right font-semibold text-stone-900">Total:</td>
                        <td class="px-4 py-3 text-stone-900 font-semibold">{{ number_format($total, 2) }}</td>
                        <td class="px-4 py-3 text-right"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <div class="text-xs text-stone-500">Only selected items will be included in your order.</div>
        <button type="submit" form="buy-form" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600 shadow-md shadow-amber-500/20">
            <i class="fa-solid fa-credit-card"></i> Buy Selected
        </button>
    </div>
@endif

<p class="mt-6 text-sm">
    <a href="/shop" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors"><i class="fa-solid fa-arrow-left text-xs"></i> Back to Shop</a>
    <a href="/customer/index" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors ml-4">Back to Customer Home</a>
</p>
@endsection
