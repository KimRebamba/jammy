<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show()
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $account = DB::table('accounts')->where('user_id', $user->id)->first();

        return view('customer.profile.show', compact('account'));
    }

    public function edit()
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $account = DB::table('accounts')->where('user_id', $user->id)->first();

        return view('customer.profile.edit', compact('account'));
    }
}
