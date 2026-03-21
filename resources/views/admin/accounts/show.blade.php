@extends('layouts.admin')

@section('title', 'View Account')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6 flex flex-col md:flex-row gap-6">
        <div class="md:w-1/3 flex justify-center items-start">
            @if($account->profile_photo_url)
                <img src="{{ asset($account->profile_photo_url) }}" width="220" class="rounded-xl border border-slate-700/80 shadow-md">
            @else
                <div class="w-40 h-40 rounded-xl border border-dashed border-slate-700 flex items-center justify-center text-slate-500 text-sm">
                    No photo
                </div>
            @endif
        </div>
        <div class="md:w-2/3 space-y-2">
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-xl font-semibold text-slate-50">Account Details</h1>
                <a href="/admin/accounts/{{ $account->user_id }}/edit" class="text-sm px-3 py-1.5 rounded-lg bg-amber-500 text-slate-900 font-semibold hover:bg-amber-400 transition-colors">Edit</a>
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                <div>
                    <dt class="text-slate-400">ID</dt>
                    <dd class="text-slate-100">{{ $account->user_id }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Username</dt>
                    <dd class="text-slate-100">{{ $account->username }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Email</dt>
                    <dd class="text-slate-100">{{ $account->email }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">First Name</dt>
                    <dd class="text-slate-100">{{ $account->first_name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Last Name</dt>
                    <dd class="text-slate-100">{{ $account->last_name }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-slate-400">Address</dt>
                    <dd class="text-slate-100">{{ $account->address }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Phone Number</dt>
                    <dd class="text-slate-100">{{ $account->phone_number }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Role</dt>
                    <dd class="text-slate-100">{{ $account->role }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Active</dt>
                    <dd class="text-slate-100">{{ $account->is_active ? 'Yes' : 'No' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Verified</dt>
                    <dd class="text-slate-100">{{ $account->email_verified_at ? 'Yes' : 'No' }}</dd>
                </div>
            </dl>
            <div class="pt-3">
                <a href="/admin/accounts" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">Back to Accounts</a>
            </div>
        </div>
    </div>
</div>
@endsection
