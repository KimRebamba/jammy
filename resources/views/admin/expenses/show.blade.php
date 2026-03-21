@extends('layouts.admin')

@section('title', 'View Expense')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold text-slate-50">Expense Details</h1>
            <a href="/admin/expenses/{{ $expense->exp_id }}/edit" class="text-sm px-3 py-1.5 rounded-lg bg-amber-500 text-slate-900 font-semibold hover:bg-amber-400 transition-colors">Edit</a>
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
            <div>
                <dt class="text-slate-400">ID</dt>
                <dd class="text-slate-100">{{ $expense->exp_id }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Type</dt>
                <dd class="text-slate-100">{{ $expense->expense_type }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-slate-400">Description</dt>
                <dd class="text-slate-100">{{ $expense->description }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Amount</dt>
                <dd class="text-slate-100">{{ $expense->amount }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Status</dt>
                <dd class="text-slate-100">{{ $expense->status }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Due Date</dt>
                <dd class="text-slate-100">{{ $expense->due_date }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Paid Date</dt>
                <dd class="text-slate-100">{{ $expense->paid_date }}</dd>
            </div>
        </dl>

        <div class="pt-4">
            <a href="/admin/expenses" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Expenses
            </a>
        </div>
    </div>
</div>
@endsection
