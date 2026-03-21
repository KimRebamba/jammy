@extends('layouts.admin')

@section('title', 'View Order')

@section('content')
<div class="bg-slate-950/40 rounded-2xl border border-slate-800 p-4">

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-slate-50">Order #{{ $order->order_id }}</h2>
        <div class="flex items-center gap-3">
            <a href="/admin/orders/{{ $order->order_id }}/edit" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-amber-500 text-slate-900 text-xs font-semibold hover:bg-amber-400 transition-colors">
                Edit Order
            </a>
            <a href="/admin/orders" class="text-amber-300 hover:text-amber-200 text-xs">Back to Orders</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-100 mb-6">
        <div>
            <p><span class="font-semibold text-slate-300">Customer:</span> {{ $order->username }}</p>
            <p><span class="font-semibold text-slate-300">Payment Status:</span> {{ $order->payment_status }}</p>
            <p><span class="font-semibold text-slate-300">Order Status:</span> {{ $order->order_status }}</p>
            <p><span class="font-semibold text-slate-300">Payment Option:</span> {{ $order->payment_option }}</p>
        </div>
        <div>
            <p><span class="font-semibold text-slate-300">Delivery Fee:</span> {{ $order->delivery_fee }}</p>
            <p><span class="font-semibold text-slate-300">Date Ordered:</span> {{ $order->date_ordered }}</p>
            <p><span class="font-semibold text-slate-300">Completed At:</span> {{ $order->completed_at }}</p>
        </div>
    </div>

    <h3 class="text-lg font-semibold text-slate-50 mb-3">Items</h3>

    <div class="overflow-x-auto rounded-xl border border-slate-800/80 bg-slate-950/60 mb-4">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-slate-900/80 text-slate-200">
                <tr>
                    <th class="px-3 py-2 border-b border-slate-800/80">Product</th>
                    <th class="px-3 py-2 border-b border-slate-800/80">Quantity</th>
                    <th class="px-3 py-2 border-b border-slate-800/80">Unit Price</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/80 text-slate-100">
                @foreach($items as $item)
                <tr>
                    <td class="px-3 py-2 align-middle">{{ $item->product_name }}</td>
                    <td class="px-3 py-2 align-middle">{{ $item->quantity }}</td>
                    <td class="px-3 py-2 align-middle">{{ $item->unit_price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
