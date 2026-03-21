@extends('layouts.customer')

@section('title', 'Order Details')

@section('content')
<h2 class="text-xl font-semibold text-stone-900 mb-4">Order #{{ $order->order_id }}</h2>

<div class="space-y-2 text-stone-700 mb-6">
    <p><strong class="text-stone-900">Date:</strong> {{ $order->date_ordered }}</p>
    <p><strong class="text-stone-900">Payment Status:</strong> {{ $order->payment_status }}</p>
    <p><strong class="text-stone-900">Order Status:</strong> {{ $order->order_status }}</p>
    <p><strong class="text-stone-900">Delivery Fee:</strong> {{ number_format($order->delivery_fee, 2) }}</p>
</div>

<h3 class="text-lg font-semibold text-stone-900 mb-2">Items</h3>
<div class="overflow-x-auto rounded-lg border border-stone-200 bg-white shadow-sm mb-6">
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-stone-100">
                <th class="p-3 text-left text-sm font-medium text-stone-700">Image</th>
                <th class="p-3 text-left text-sm font-medium text-stone-700">Product</th>
                <th class="p-3 text-left text-sm font-medium text-stone-700">Quantity</th>
                <th class="p-3 text-left text-sm font-medium text-stone-700">Unit Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr class="border-t border-stone-200">
                    <td class="p-3">
                        @if($item->photo_url)
                            <img src="{{ asset($item->photo_url) }}" alt="{{ $item->product_name }}" width="80" class="rounded border border-stone-200">
                        @endif
                    </td>
                    <td class="p-3 text-stone-900">{{ $item->product_name }}</td>
                    <td class="p-3 text-stone-700">{{ $item->quantity }}</td>
                    <td class="p-3 text-stone-700">{{ number_format($item->unit_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<p class="space-x-4 text-sm">
    <a href="/orders" class="text-amber-600 hover:text-amber-700 transition-colors">Back to Orders</a>
    <a href="/customer/index" class="text-amber-600 hover:text-amber-700 transition-colors">Back to Customer Home</a>
</p>
@endsection
