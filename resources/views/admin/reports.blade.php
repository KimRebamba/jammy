@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="mb-6">
    <h2 class="text-2xl font-semibold text-slate-50 mb-1">Business Reports Summary</h2>
    <p class="text-sm text-slate-400">High-level overview of sales, expenses and store activity.</p>
</div>

<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 mb-8">
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4">
        <p class="text-xs text-slate-400 mb-1">Total Sales Revenue</p>
        <p class="text-xl font-semibold text-amber-300">{{ $totalSales->total ?? 0 }}</p>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4">
        <p class="text-xs text-slate-400 mb-1">Total Paid Expenses</p>
        <p class="text-xl font-semibold text-rose-300">{{ $totalExpenses }}</p>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4">
        <p class="text-xs text-slate-400 mb-1">Estimated Profit</p>
        <p class="text-xl font-semibold text-emerald-300">{{ ($totalSales->total ?? 0) - $totalExpenses }}</p>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4">
        <p class="text-xs text-slate-400 mb-1">Total Orders</p>
        <p class="text-xl font-semibold text-slate-50">{{ $totalOrders }}</p>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4">
        <p class="text-xs text-slate-400 mb-1">Total Products</p>
        <p class="text-xl font-semibold text-slate-50">{{ $totalProducts }}</p>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4">
        <p class="text-xs text-slate-400 mb-1">Customers / Employees</p>
        <p class="text-xl font-semibold text-slate-50">{{ $totalCustomers }} / {{ $totalEmployees }}</p>
    </div>
</div>

<div class="grid gap-8 lg:grid-cols-2 mb-8">
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4">
        <h3 class="text-sm font-semibold text-slate-100 mb-3">Yearly Sales</h3>
        <div class="relative max-h-64 overflow-hidden">
            {!! $yearlyChart->container() !!}
        </div>
    </div>

    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4">
        <div class="flex items-center justify-between mb-3 gap-3">
            <h3 class="text-sm font-semibold text-slate-100">Sales by Date Range</h3>
            <form method="GET" action="/admin/reports" class="flex flex-wrap items-center gap-2 text-xs">
                <label class="flex items-center gap-1 text-slate-300">
                    <span>Start</span>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="rounded border border-slate-600 bg-slate-900 text-slate-100 px-2 py-1 text-xs">
                </label>
                <label class="flex items-center gap-1 text-slate-300">
                    <span>End</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="rounded border border-slate-600 bg-slate-900 text-slate-100 px-2 py-1 text-xs">
                </label>
                <button type="submit" class="px-3 py-1.5 rounded bg-amber-500 text-slate-950 font-semibold hover:bg-amber-400">Apply</button>
            </form>
        </div>
        <div class="relative max-h-64 overflow-hidden">
            {!! $rangeChart->container() !!}
        </div>
    </div>
</div>

<div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4 mb-4">
    <h3 class="text-sm font-semibold text-slate-100 mb-3">Sales by Product (Percentage)</h3>
    <div class="relative max-h-64 overflow-hidden">
        {!! $productChart->container() !!}
    </div>
</div>

<p class="text-xs text-slate-400"><a href="/admin/dashboard" class="text-amber-300 hover:text-amber-200 inline-flex items-center gap-1"><i class="fa-solid fa-arrow-left text-[10px]"></i> Back to dashboard</a></p>
{!! $yearlyChart->script() !!}
{!! $rangeChart->script() !!}
{!! $productChart->script() !!}
@endsection