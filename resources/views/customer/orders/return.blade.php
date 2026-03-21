@extends('layouts.customer')

@section('title', 'Request Return')

@section('content')
<h2 class="text-xl font-semibold text-stone-900 mb-4">Request Return for Order #{{ $order->order_id }}</h2>

@if($errors->any())
    <ul class="text-sm text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2 mb-4">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<p class="text-stone-700 mb-4"><strong class="text-stone-900">Status:</strong> {{ $order->order_status }}</p>

<h3 class="text-lg font-semibold text-stone-900 mb-2">Items</h3>
<div class="overflow-x-auto rounded-lg border border-stone-200 bg-white shadow-sm mb-6">
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-stone-100">
                <th class="p-3 text-left text-sm font-medium text-stone-700">Product</th>
                <th class="p-3 text-left text-sm font-medium text-stone-700">Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr class="border-t border-stone-200">
                    <td class="p-3 text-stone-900">{{ $item->product_name }}</td>
                    <td class="p-3 text-stone-700">{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<h3 class="text-lg font-semibold text-stone-900 mb-2">Return Details</h3>
<div class="rounded-lg border border-stone-200 bg-white shadow-sm p-6 max-w-lg">
    <form action="/orders/{{ $order->order_id }}/return" method="post" class="space-y-4">
        @csrf
        <div>
            <label for="reason" class="block text-sm font-medium text-stone-700 mb-1">Reason</label>
            <input type="text" name="reason" id="reason" value="{{ old('reason') }}" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
        </div>
        <div>
            <label for="cond" class="block text-sm font-medium text-stone-700 mb-1">Condition</label>
            <select name="cond" id="cond" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                @foreach($conditions as $cond)
                    <option value="{{ $cond }}" @if(old('cond') === $cond) selected @endif>{{ ucfirst($cond) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition-colors">Submit Return Request</button>
    </form>
</div>

<p class="mt-4 space-x-4 text-sm">
    <a href="/orders" class="text-amber-600 hover:text-amber-700 transition-colors">Back to Orders</a>
    <a href="/customer/index" class="text-amber-600 hover:text-amber-700 transition-colors">Back to Customer Home</a>
</p>
@endsection
