@extends('layouts.admin')

@section('title', 'Edit Employee')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Edit Employee</h1>
            <a href="/admin/employees" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Employees
            </a>
        </div>

        @if($errors->any())
            <ul class="mb-4 text-sm text-red-300 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="/admin/employees/{{ $employee->emp_id }}/update" method="post" class="space-y-3">
            @csrf
            <p>First Name: <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Last Name: <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Email: <input type="text" name="email" value="{{ old('email', $employee->email) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Phone Number: <input type="text" name="phone_number" value="{{ old('phone_number', $employee->phone_number) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Address: <input type="text" name="address" value="{{ old('address', $employee->address) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Birth Date: <input type="text" name="birth_date" value="{{ old('birth_date', $employee->birth_date) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Gender:
                <select name="gender" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="">--</option>
                    <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </p>
            <p>Employment Status:
                <select name="employment_status" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="active" {{ old('employment_status', $employee->employment_status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('employment_status', $employee->employment_status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="terminated" {{ old('employment_status', $employee->employment_status) == 'terminated' ? 'selected' : '' }}>Terminated</option>
                    <option value="on_leave" {{ old('employment_status', $employee->employment_status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                </select>
            </p>
            <p>Hire Date: <input type="text" name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Position:
                <select name="current_position_id" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="">-- none --</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->position_id }}" {{ old('current_position_id', $employee->current_position_id) == $position->position_id ? 'selected' : '' }}>{{ $position->position_name }}</option>
                    @endforeach
                </select>
            </p>

            <p>
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition-colors">
                    Save Changes
                </button>
            </p>
        </form>
    </div>
</div>
@endsection
