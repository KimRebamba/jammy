@extends('layouts.customer')

@section('title', 'My Orders')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
        <i class="fa-solid fa-box-open text-amber-600 text-xl"></i>
    </div>
    <h2 class="text-xl font-bold text-stone-900">My Orders</h2>
</div>

@if($orders->isEmpty())
    <div class="rounded-2xl border border-dashed border-stone-300 bg-white/60 p-6 text-center text-stone-600">
        <p class="font-medium mb-2">You don&apos;t have any orders yet.</p>
        <a href="/shop" class="inline-flex items-center gap-2 px-4 py-2 mt-2 rounded-xl bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600 shadow-sm">
            <i class="fa-solid fa-shop"></i> Start shopping
        </a>
    </div>
@else
    <div class="bg-white rounded-2xl border border-stone-200 shadow-lg shadow-stone-200/50">
        <div class="overflow-x-auto rounded-2xl">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gradient-to-r from-stone-100 to-stone-50">
                    <tr class="text-left text-stone-600">
                        <th class="px-4 py-3 font-semibold">ID</th>
                        <th class="px-4 py-3 font-semibold">Date</th>
                        <th class="px-4 py-3 font-semibold">Payment</th>
                        <th class="px-4 py-3 font-semibold">Payment Status</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold">Items</th>
                        <th class="px-4 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-t border-stone-100 hover:bg-stone-50/60">
                            <td class="px-4 py-3 text-stone-900 font-medium">#{{ $order->order_id }}</td>
                            <td class="px-4 py-3 text-stone-700">{{ $order->date_ordered }}</td>
                            <td class="px-4 py-3 text-stone-700">{{ $order->payment_option }}</td>
                            <td class="px-4 py-3 text-stone-700">{{ $order->payment_status }}</td>
                            <td class="px-4 py-3 text-stone-700">{{ $order->order_status }}</td>
                            <td class="px-4 py-3 text-stone-700 align-top max-w-xs">
                                <span class="line-clamp-2">{{ $order->items }}</span>
                            </td>
                            <td class="px-4 py-3 text-right text-xs">
                                <div class="inline-flex flex-wrap items-center gap-2 justify-end">
                                    <a href="/orders/{{ $order->order_id }}" class="text-amber-600 hover:text-amber-700 font-medium">View</a>

                                    @if($order->order_status == 'completed')
                                        <span class="text-stone-400">|</span>
                                        <a href="/orders/{{ $order->order_id }}/return" class="text-stone-700 hover:text-stone-900">Return</a>
                                        <span class="text-stone-400">|</span>
                                        <a href="/orders/{{ $order->order_id }}/review" class="text-stone-700 hover:text-stone-900">Review</a>
                                    @endif

                                    @if($order->order_status !== 'completed' && $order->order_status !== 'cancelled' && $order->order_status !== 'returned')
                                        <span class="text-stone-400">|</span>
                                        <form action="/orders/{{ $order->order_id }}/cancel" method="post" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-600">Cancel</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<p class="mt-4 text-sm">
    <a href="/customer/index" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors"><i class="fa-solid fa-arrow-left text-xs"></i> Back to Customer Home</a>
    <a href="/shop" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 transition-colors ml-4">Back to Shop</a>
</p>
@endsection
