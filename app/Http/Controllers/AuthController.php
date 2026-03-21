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
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $categoryId = $request->query('category_id');
        $brandId = $request->query('brand_id');
        $type = $request->query('type');

        if ($searchTerm !== '') {
            $builder = Product::search($searchTerm);
        } else {
            $builder = Product::query();
        }

        $builder->where('is_active', 1);

        if ($minPrice !== null && $minPrice !== '' && is_numeric($minPrice)) {
            $builder->where('retail_price', '>=', (float) $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '' && is_numeric($maxPrice)) {
            $builder->where('retail_price', '<=', (float) $maxPrice);
        }

        if ($categoryId !== null && $categoryId !== '' && ctype_digit((string) $categoryId)) {
            $builder->where('category_id', (int) $categoryId);
        }

        if ($brandId !== null && $brandId !== '' && ctype_digit((string) $brandId)) {
            $builder->where('brand_id', (int) $brandId);
        }

        if ($type !== null && $type !== '') {
            $builder->where('model', 'like', '%' . $type . '%');
        }

        $products = $builder
            ->orderBy('product_name')
            ->paginate(12)
            ->appends($request->query());

        $productIds = collect($products->items())
            ->pluck('product_id')
            ->filter()
            ->values();

        if ($productIds->isNotEmpty()) {
            $photoRows = DB::table('product_photos')
                ->whereIn('product_id', $productIds)
                ->where('is_primary', 1)
                ->get()
                ->keyBy('product_id');

            $metaRows = DB::table('products as p')
                ->leftJoin('brands as b', 'p.brand_id', '=', 'b.brand_id')
                ->leftJoin('categories as c', 'p.category_id', '=', 'c.category_id')
                ->whereIn('p.product_id', $productIds)
                ->select('p.product_id', 'b.brand_name', 'c.category_name')
                ->get()
                ->keyBy('product_id');

            foreach ($products as $product) {
                $photo = $photoRows->get($product->product_id);
                $product->photo_url = $photo ? $photo->photo_url : null;

                $meta = $metaRows->get($product->product_id);
                if ($meta) {
                    $product->brand_name = $meta->brand_name;
                    $product->category_name = $meta->category_name;
                }
            }
        }

        $categories = DB::table('categories')
            ->orderBy('category_name')
            ->get();

        $brands = DB::table('brands')
            ->orderBy('brand_name')
            ->get();

        $typeOptions = DB::table('products')
            ->whereNotNull('model')
            ->distinct()
            ->orderBy('model')
            ->pluck('model')
            ->toArray();

        return view('home', [
            'searchTerm' => $searchTerm,
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'typeOptions' => $typeOptions,
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
                'email_verified_at',
                'deleted_at'
            )
            ->where('username', $request->username)
            ->first();

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid Credentials');
        }

        if (!$user->is_active || !is_null($user->deleted_at)) {
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