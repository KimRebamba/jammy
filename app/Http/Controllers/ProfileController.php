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

    public function update(Request $request)
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $account = DB::table('accounts')->where('user_id', $user->id)->first();
        if (!$account) {
            return redirect('/customer/profile')->with('error', 'Account not found');
        }

        $data = $request->validate([
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
        ]);

        DB::table('accounts')->where('user_id', $user->id)->update([
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'address' => $data['address'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect('/customer/profile')->with('success', 'Profile updated successfully');
    }
}
