@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-semibold text-slate-50 mb-1">Admin Dashboard</h2>
    <p class="text-sm text-slate-400">Welcome, <span class="font-semibold text-amber-300">{{ session('user')->username }}</span>. Choose a section to manage below.</p>
</div>

<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
    <a href="/admin/accounts" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-users text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Accounts</h3>
            <p class="text-xs text-slate-400">Customers, admins and profile details</p>
        </div>
    </a>

    <a href="/admin/products" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-box text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Products</h3>
            <p class="text-xs text-slate-400">Inventory, photos and pricing</p>
        </div>
    </a>

    <a href="/admin/categories" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-tags text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Categories</h3>
            <p class="text-xs text-slate-400">Organise your catalog structure</p>
        </div>
    </a>

    <a href="/admin/brands" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-copyright text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Brands</h3>
            <p class="text-xs text-slate-400">Logos and brand metadata</p>
        </div>
    </a>

    <a href="/admin/orders" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-truck-fast text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Orders</h3>
            <p class="text-xs text-slate-400">Track fulfilment status</p>
        </div>
    </a>

    <a href="/admin/returns" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-rotate-left text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Returns</h3>
            <p class="text-xs text-slate-400">Handle product returns &amp; refunds</p>
        </div>
    </a>

    <a href="/admin/reviews" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-star text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Reviews</h3>
            <p class="text-xs text-slate-400">Customer feedback on products</p>
        </div>
    </a>

    <a href="/admin/employees" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-user-tie text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Employees</h3>
            <p class="text-xs text-slate-400">Team and employment status</p>
        </div>
    </a>

    <a href="/admin/positions" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-briefcase text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Positions</h3>
            <p class="text-xs text-slate-400">Job roles and base rates</p>
        </div>
    </a>

    <a href="/admin/salaries" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-money-bill-wave text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Salaries</h3>
            <p class="text-xs text-slate-400">Payroll and pay history</p>
        </div>
    </a>

    <a href="/admin/expenses" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-receipt text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Expenses</h3>
            <p class="text-xs text-slate-400">Track store expenses</p>
        </div>
    </a>

    <a href="/admin/reports" class="group rounded-2xl border border-slate-800 bg-slate-900/80 hover:bg-slate-900 hover:border-amber-500/40 transition-all p-4 flex items-center gap-3 shadow-sm hover:shadow-amber-500/20">
        <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fa-solid fa-chart-line text-amber-400"></i></div>
        <div>
            <h3 class="font-semibold text-slate-50 group-hover:text-amber-300">Reports</h3>
            <p class="text-xs text-slate-400">Sales, expenses and performance</p>
        </div>
    </a>
</div>
@endsection