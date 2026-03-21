@extends('layouts.admin')

@section('title', 'Edit Return')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Edit Return Status</h1>
            <a href="/admin/returns" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                Back to Returns
            </a>
        </div>

        @if($errors->any())
            <ul class="mb-4 text-sm text-red-300 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="/admin/returns/{{ $return->order_return_id }}/update" method="post" class="space-y-3">
            @csrf
            <p>Status:
                <select name="return_status" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm">
                    <option value="requested" {{ old('return_status', $return->return_status) == 'requested' ? 'selected' : '' }}>Requested</option>
                    <option value="approved" {{ old('return_status', $return->return_status) == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ old('return_status', $return->return_status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="processed" {{ old('return_status', $return->return_status) == 'processed' ? 'selected' : '' }}>Processed</option>
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
