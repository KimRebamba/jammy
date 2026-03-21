@extends('layouts.admin')

@section('title', 'Edit Order')

@section('content')
<div class="bg-slate-950/40 rounded-2xl border border-slate-800 p-4 max-w-3xl">

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-slate-50">Edit Order #{{ $order->order_id }}</h2>
    </div>

    @if($errors->any())
        <ul class="mb-3 text-sm text-red-300 list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/admin/orders/{{ $order->order_id }}/update" method="post" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Payment Status</label>
                <select name="payment_status" class="w-full rounded-md border border-slate-700 bg-slate-900/80 text-sm text-slate-100 px-2 py-1.5">
                    <option value="pending" {{ old('payment_status', $order->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="refunded" {{ old('payment_status', $order->payment_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Order Status</label>
                <select name="order_status" class="w-full rounded-md border border-slate-700 bg-slate-900/80 text-sm text-slate-100 px-2 py-1.5">
                    <option value="pending" {{ old('order_status', $order->order_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ old('order_status', $order->order_status) == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ old('order_status', $order->order_status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="completed" {{ old('order_status', $order->order_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('order_status', $order->order_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="requested_refund" {{ old('order_status', $order->order_status) == 'requested_refund' ? 'selected' : '' }}>Requested Refund</option>
                    <option value="returned" {{ old('order_status', $order->order_status) == 'returned' ? 'selected' : '' }}>Returned</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Payment Option</label>
                <input type="text" name="payment_option" value="{{ old('payment_option', $order->payment_option) }}" class="w-full rounded-md border border-slate-700 bg-slate-900/80 text-sm text-slate-100 px-2 py-1.5">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Delivery Fee</label>
                <input type="text" name="delivery_fee" value="{{ old('delivery_fee', $order->delivery_fee) }}" class="w-full rounded-md border border-slate-700 bg-slate-900/80 text-sm text-slate-100 px-2 py-1.5">
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition-colors">
                Save Changes
            </button>
            <a href="/admin/orders" class="text-amber-300 hover:text-amber-200 text-xs">Back to Orders</a>
        </div>

    </form>

</div>
@endsection
