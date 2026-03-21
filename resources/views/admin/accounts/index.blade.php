@extends('layouts.admin')

@section('title', 'Accounts')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
    integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="bg-slate-950/40 rounded-2xl border border-slate-800 p-4">

    <div class="flex items-center justify-between mb-2">
        <h2 class="text-xl font-semibold text-slate-50">Accounts</h2>
        <a href="/admin/accounts/create" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition-colors">
            Add Account
        </a>
    </div>

    <form method="GET" class="mb-3 flex items-center justify-end gap-2 text-xs text-slate-300">
        <label for="deleted-filter-accounts">Show:</label>
        <select id="deleted-filter-accounts" name="deleted" class="rounded-md border border-slate-700 bg-slate-900/80 text-xs px-2 py-1" onchange="this.form.submit()">
            <option value="" {{ request('deleted') === null || request('deleted') === '' ? 'selected' : '' }}>Active only</option>
            <option value="with" {{ request('deleted') === 'with' ? 'selected' : '' }}>Active + deleted</option>
            <option value="only" {{ request('deleted') === 'only' ? 'selected' : '' }}>Deleted only</option>
        </select>
    </form>

    @if($errors->any())
        <ul class="mb-3 text-sm text-red-300 list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="post" action="/admin/accounts/batch">
        @csrf

        <div class="rounded-xl border border-slate-800/80 bg-slate-950/60">
            {!! $dataTable->table(['class' => 'min-w-full text-sm text-left', 'id' => 'accounts-table']) !!}
        </div>

        <div class="mt-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <select name="action" class="rounded-md border border-slate-700 bg-slate-900/80 text-xs text-slate-100 px-2 py-1">
                    <option value="">-- Batch Action --</option>
                    <option value="activate">Activate Selected</option>
                    <option value="deactivate">Deactivate Selected</option>
                    <option value="delete">Delete Selected</option>
                    <option value="restore">Restore Selected</option>
                </select>
                <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-500/80 hover:bg-red-400 text-slate-950 text-xs font-semibold">
                    Apply
                </button>
            </div>
            <a href="/admin/dashboard" class="text-amber-300 hover:text-amber-200 text-xs">Back to dashboard</a>
        </div>

    </form>

</div>

{!! $dataTable->scripts() !!}
@endsection
