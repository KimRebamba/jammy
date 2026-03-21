<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerifyAccount;
use App\Models\Product;

class AuthController extends Controller
{

    public function home(Request $request)
    {
        $searchTerm = trim((string) $request->query('q', ''));

        $products = null;

        if ($searchTerm !== '') {
            $products = Product::search($searchTerm)
                ->where('is_active', 1)
                ->paginate(10);

            foreach ($products as $product) {
                $photo = DB::table('product_photos')
                    ->where('product_id', $product->product_id)
                    ->where('is_primary', 1)
                    ->first();

                $product->photo_url = $photo ? $photo->photo_url : null;
            }
        }

        return view('home', [
            'searchTerm' => $searchTerm,
            'products' => $products,
        ]);
    }
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
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
                'is_active',
                'email_verified_at'
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

        if (is_null($user->email_verified_at)) {
            return back()->with('error', 'Please verify your email before logging in.');
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

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50|unique:accounts,username',
            'email' => 'required|email|max:100|unique:accounts,email',
            'password' => 'required|string|min:4|confirmed',
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = uniqid('profile_', true) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profiles'), $filename);
            $profilePhotoPath = 'images/profiles/' . $filename;
        }

        $verificationToken = Str::random(60);

        $userId = DB::table('accounts')->insertGetId([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'address' => $data['address'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'role' => 'customer',
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'profile_photo_url' => $profilePhotoPath,
            'is_active' => 1,
            'email_verified_at' => null,
            'verification_token' => $verificationToken,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $verificationUrl = url('/verify-email/' . $verificationToken);

        Mail::to($data['email'])->send(new VerifyAccount($verificationUrl));

        return redirect('/login')->with('success', 'Registration successful. Please check your email to verify your account.');
    }

    public function verifyEmail($token)
    {
        $account = DB::table('accounts')
            ->where('verification_token', $token)
            ->first();

        if (!$account) {
            return redirect('/login')->with('error', 'Invalid or expired verification link.');
        }

        DB::table('accounts')
            ->where('user_id', $account->user_id)
            ->update([
                'email_verified_at' => now(),
                'verification_token' => null,
                'updated_at' => now(),
            ]);

        return redirect('/login')->with('success', 'Email verified. You can now log in.');
    }

    public function logout()
    {
        session()->forget('user');
        return redirect('/home');
    }
}