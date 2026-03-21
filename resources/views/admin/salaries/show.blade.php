@extends('layouts.admin')

@section('title', 'View Salary')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold text-slate-50">Salary Details</h1>
            <a href="/admin/salaries/{{ $salary->salary_id }}/edit" class="text-sm px-3 py-1.5 rounded-lg bg-amber-500 text-slate-900 font-semibold hover:bg-amber-400 transition-colors">Edit</a>
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
            <div>
                <dt class="text-slate-400">ID</dt>
                <dd class="text-slate-100">{{ $salary->salary_id }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Employee</dt>
                <dd class="text-slate-100">{{ $salary->employee_name }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Pay Date</dt>
                <dd class="text-slate-100">{{ $salary->pay_date }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Rate Used</dt>
                <dd class="text-slate-100">{{ $salary->rate_used }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Status</dt>
                <dd class="text-slate-100">{{ $salary->status }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">From Date</dt>
                <dd class="text-slate-100">{{ $salary->from_date }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">To Date</dt>
                <dd class="text-slate-100">{{ $salary->to_date }}</dd>
            </div>
        </dl>

        <div class="pt-4">
            <a href="/admin/salaries" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Salaries
            </a>
        </div>
    </div>
</div>
@endsection
