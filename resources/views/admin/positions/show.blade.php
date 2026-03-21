@extends('layouts.admin')

@section('title', 'View Position')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold text-slate-50">Position Details</h1>
            <a href="/admin/positions/{{ $position->position_id }}/edit" class="text-sm px-3 py-1.5 rounded-lg bg-amber-500 text-slate-900 font-semibold hover:bg-amber-400 transition-colors">Edit</a>
        </div>

        <dl class="grid grid-cols-1 gap-y-2 text-sm">
            <div>
                <dt class="text-slate-400">ID</dt>
                <dd class="text-slate-100">{{ $position->position_id }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Name</dt>
                <dd class="text-slate-100">{{ $position->position_name }}</dd>
            </div>
            <div>
                <dt class="text-slate-400">Monthly Rate</dt>
                <dd class="text-slate-100">{{ $position->monthly_rate }}</dd>
            </div>
        </dl>

        <div class="pt-4">
            <a href="/admin/positions" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Positions
            </a>
        </div>
    </div>
</div>
@endsection
