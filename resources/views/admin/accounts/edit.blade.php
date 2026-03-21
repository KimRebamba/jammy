@extends('layouts.admin')

@section('title', 'Edit Account')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Edit Account</h1>
            <a href="/admin/accounts" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                Back to Accounts
            </a>
        </div>

        @if($errors->any())
            <ul class="mb-4 text-sm text-red-300 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="/admin/accounts/{{ $account->user_id }}/update" method="post" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <p>Username:
                <input type="text" name="username" value="{{ old('username', $account->username) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
            </p>
            <p>New Password (leave blank to keep):
                <input type="password" name="password" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
            </p>
            <p>Email:
                <input type="email" name="email" value="{{ old('email', $account->email) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
            </p>
            <p>First Name:
                <input type="text" name="first_name" value="{{ old('first_name', $account->first_name) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
            </p>
            <p>Last Name:
                <input type="text" name="last_name" value="{{ old('last_name', $account->last_name) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
            </p>
            <p>Address:
                <input type="text" name="address" value="{{ old('address', $account->address) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
            </p>
            <p>Phone Number:
                <input type="text" name="phone_number" value="{{ old('phone_number', $account->phone_number) }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
            </p>
            <p>Role:
                <select name="role" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="customer" {{ old('role', $account->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin" {{ old('role', $account->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </p>
            <p>Profile Photo (800x800):
                <input type="file" name="profile_photo_url" class="mt-1 block w-full text-sm text-slate-200">
            </p>
            <p class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $account->is_active) ? 'checked' : '' }} class="rounded border-slate-600 bg-slate-900">
                <span>Active</span>
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
