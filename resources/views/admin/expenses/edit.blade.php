@extends('layouts.admin')

@section('title', 'Edit Expense')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Edit Expense</h1>
            <a href="/admin/expenses" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Expenses
            </a>
        </div>

        @if($errors->any())
            <ul class="mb-4 text-sm text-red-300 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="/admin/expenses/{{ $expense->exp_id }}/update" method="post" class="space-y-3">
            @csrf
            <p>Type:
                <select name="expense_type" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="inventory_purchase" {{ old('expense_type', $expense->expense_type) == 'inventory_purchase' ? 'selected' : '' }}>Inventory Purchase</option>
                    <option value="shipping" {{ old('expense_type', $expense->expense_type) == 'shipping' ? 'selected' : '' }}>Shipping</option>
                    <option value="maintenance" {{ old('expense_type', $expense->expense_type) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="rent" {{ old('expense_type', $expense->expense_type) == 'rent' ? 'selected' : '' }}>Rent</option>
                    <option value="utilities" {{ old('expense_type', $expense->expense_type) == 'utilities' ? 'selected' : '' }}>Utilities</option>
                    <option value="other" {{ old('expense_type', $expense->expense_type) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </p>
            <p>Description: <input type="text" name="description" value="{{ old('description', $expense->description) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Amount: <input type="text" name="amount" value="{{ old('amount', $expense->amount) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Status:
                <select name="status" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="pending" {{ old('status', $expense->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ old('status', $expense->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </p>
            <p>Due Date: <input type="text" name="due_date" value="{{ old('due_date', $expense->due_date) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Paid Date: <input type="text" name="paid_date" value="{{ old('paid_date', $expense->paid_date) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>

            <p>
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition-colors">
                    Save Changes
                </button>
            </p>
        </form>
    </div>
</div>
@endsection
