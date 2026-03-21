@extends('layouts.admin')

@section('title', 'View Employee')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold text-slate-50">Employee Details</h1>
            <a href="/admin/employees/{{ $employee->emp_id }}/edit" class="text-sm px-3 py-1.5 rounded-lg bg-amber-500 text-slate-900 font-semibold hover:bg-amber-400 transition-colors">Edit</a>
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
            <div>
                <dt class="text-slate-400">ID</dt>
                <dd class="text-slate-100">{{ $employee->emp_id }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">First Name</dt>
                <dd class="text-slate-100">{{ $employee->first_name }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Last Name</dt>
                <dd class="text-slate-100">{{ $employee->last_name }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Email</dt>
                <dd class="text-slate-100">{{ $employee->email }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Phone Number</dt>
                <dd class="text-slate-100">{{ $employee->phone_number }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Address</dt>
                <dd class="text-slate-100">{{ $employee->address }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Birth Date</dt>
                <dd class="text-slate-100">{{ $employee->birth_date }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Gender</dt>
                <dd class="text-slate-100">{{ $employee->gender }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Employment Status</dt>
                <dd class="text-slate-100">{{ $employee->employment_status }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Hire Date</dt>
                <dd class="text-slate-100">{{ $employee->hire_date }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-slate-400">Position</dt>
                <dd class="text-slate-100">{{ $employee->position_name }}</dd>
            </div>
        </dl>

        <div class="pt-4">
            <a href="/admin/employees" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Employees
            </a>
        </div>
    </div>
</div>
@endsection
