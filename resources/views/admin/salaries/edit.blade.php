@extends('layouts.admin')

@section('title', 'Edit Salary')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Edit Salary</h1>
            <a href="/admin/salaries" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Salaries
            </a>
        </div>

        @if($errors->any())
            <ul class="mb-4 text-sm text-red-300 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="/admin/salaries/{{ $salary->salary_id }}/update" method="post" class="space-y-3">
            @csrf
            <p>Employee:
                <select name="emp_id" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->emp_id }}" {{ old('emp_id', $salary->emp_id) == $employee->emp_id ? 'selected' : '' }}>
                            {{ $employee->last_name }}, {{ $employee->first_name }}
                        </option>
                    @endforeach
                </select>
            </p>
            <p>Pay Date: <input type="text" name="pay_date" value="{{ old('pay_date', $salary->pay_date) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Rate Used: <input type="text" name="rate_used" value="{{ old('rate_used', $salary->rate_used) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Status:
                <select name="status" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="pending" {{ old('status', $salary->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ old('status', $salary->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="cancelled" {{ old('status', $salary->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </p>
            <p>From Date: <input type="text" name="from_date" value="{{ old('from_date', $salary->from_date) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>To Date: <input type="text" name="to_date" value="{{ old('to_date', $salary->to_date) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>

            <p>
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition-colors">
                    Save Changes
                </button>
            </p>
        </form>
    </div>
</div>
@endsection
