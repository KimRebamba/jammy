<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function home(){
        return view('home');
    }
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = DB::table('accounts')
            ->select(
                'user_id as id',
                'username',
                'password',
                'role',
                'is_active'
            )
            ->where('username', $request->username)
            ->first();

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid Credentials');
        }

        if (!$user->is_active) {
            return back()->with('error', 'Account inactive');
        }

        session(['user' => $user]);

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } 
        
        if ($user->role === 'customer') {
            return redirect('/customer/index');
        }

        return redirect('/home');
    }

    public function logout()
    {
        session()->forget('user');
        return redirect('/home');
    }
}