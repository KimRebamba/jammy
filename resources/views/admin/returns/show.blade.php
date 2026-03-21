@extends('layouts.admin')

@section('title', 'Return Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Return Details</h1>
            <div class="flex items-center gap-3">
                <a href="/admin/returns/{{ $return->order_return_id }}/edit" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-800 text-xs font-semibold text-slate-100 hover:bg-slate-700 transition-colors">Edit</a>
                <a href="/admin/returns" class="text-xs text-amber-400 hover:text-amber-300 transition-colors">Back to Returns</a>
            </div>
        </div>

        <dl class="divide-y divide-slate-800 text-sm">
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Return ID</dt>
                <dd class="text-slate-50 font-medium">{{ $return->order_return_id }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Order ID</dt>
                <dd class="text-slate-50 font-medium">{{ $return->order_id }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Customer</dt>
                <dd class="text-slate-100">{{ $return->username }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Reason</dt>
                <dd class="text-slate-100 max-w-sm text-right">{{ $return->reason }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Condition</dt>
                <dd class="text-slate-100">{{ $return->cond }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Status</dt>
                <dd class="text-slate-50 font-medium">{{ ucfirst($return->return_status) }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Refund Amount</dt>
                <dd class="text-slate-100">{{ $return->refund_amount }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="text-slate-400">Processed At</dt>
                <dd class="text-slate-100">{{ $return->processed_at }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection
