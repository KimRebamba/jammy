@extends('layouts.customer')

@section('title', 'Confirm Order')

@section('content')
<h2 class="text-xl font-semibold text-stone-900 mb-4">Confirm Order</h2>

@if(session('error'))
    <p class="mb-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2">{{ session('error') }}</p>
@endif
@if(session('success'))
    <p class="mb-3 text-sm text-emerald-700 bg-emerald-100 border border-emerald-300 rounded-md px-3 py-2">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <ul class="mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="grid gap-6 lg:grid-cols-2 mb-6">
    <div class="rounded-2xl border border-stone-200 bg-white shadow-sm p-5 space-y-1">
        <h3 class="font-semibold text-stone-900 mb-2">Customer Information</h3>
        @if($account)
            <p class="text-sm text-stone-700"><strong class="text-stone-900">Name:</strong> {{ $account->first_name }} {{ $account->last_name }}</p>
            <p class="text-sm text-stone-700"><strong class="text-stone-900">Address:</strong> {{ $account->address }}</p>
            <p class="text-sm text-stone-700"><strong class="text-stone-900">Phone:</strong> {{ $account->phone_number }}</p>
            <p class="text-sm text-stone-700"><strong class="text-stone-900">Email:</strong> {{ $account->email }}</p>
        @endif
        <p class="text-sm text-stone-700 mt-2"><strong class="text-stone-900">Delivery Fee:</strong> 50.00</p>
    </div>

    <div class="rounded-2xl border border-stone-200 bg-white shadow-sm p-5">
        <h3 class="font-semibold text-stone-900 mb-3">Selected Products</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-stone-100">
                        <th class="p-2 text-left font-medium text-stone-700">Product</th>
                        <th class="p-2 text-left font-medium text-stone-700">Price</th>
                        <th class="p-2 text-left font-medium text-stone-700">Quantity</th>
                        <th class="p-2 text-left font-medium text-stone-700">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($items as $item)
                        @php $subtotal = $item->quantity * $item->retail_price; $total += $subtotal; @endphp
                        <tr class="border-t border-stone-200">
                            <td class="p-2 text-stone-900">{{ $item->product_name }}</td>
                            <td class="p-2 text-stone-700">{{ number_format($item->retail_price, 2) }}</td>
                            <td class="p-2 text-stone-700">{{ $item->quantity }}</td>
                            <td class="p-2 text-stone-900 font-medium">{{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="border-t border-stone-300 bg-stone-50">
                        <td colspan="3" class="p-2 text-right font-semibold text-stone-900">Total:</td>
                        <td class="p-2 text-stone-900 font-semibold">{{ number_format($total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="rounded-2xl border border-stone-200 bg-white shadow-sm p-5 max-w-lg">
    <h3 class="font-semibold text-stone-900 mb-3">Payment Option</h3>
    <form action="/cart/buy/confirm" method="post" class="space-y-4">
        @csrf
        @foreach($items as $item)
            <input type="hidden" name="items[]" value="{{ $item->cart_product_id }}">
        @endforeach
        <div>
            <label for="payment_option" class="block text-sm font-medium text-stone-700 mb-1">Select payment option</label>
            <select name="payment_option" id="payment_option" class="w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                @foreach($paymentOptions as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 shadow-md shadow-amber-500/20 transition-colors">
            Confirm Order
        </button>
    </form>
</div>

<p class="mt-4 text-sm">
    <a href="/cart" class="text-amber-600 hover:text-amber-700 transition-colors">Back to Cart</a>
</p>
@endsection
