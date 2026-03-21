@extends('layouts.admin')

@section('title', 'Add Position')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-slate-900/70 border border-slate-700/60 rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Add Position</h1>
            <a href="/admin/positions" class="text-sm text-amber-400 hover:text-amber-300 transition-colors">
                
                Back to Positions
            </a>
        </div>

        @if($errors->any())
            <ul class="mb-4 text-sm text-red-300 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="/admin/positions" method="post" class="space-y-3">
            @csrf
            <p>Name: <input type="text" name="position_name" value="{{ old('position_name') }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>
            <p>Monthly Rate: <input type="text" name="monthly_rate" value="{{ old('monthly_rate') }}" class="mt-1 px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 w-full text-sm"></p>

            <p>
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition-colors">
                    Save Position
                </button>
            </p>
        </form>
    </div>
</div>
@endsection
