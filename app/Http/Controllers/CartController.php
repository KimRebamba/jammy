<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $cart = DB::table('cart')->where('user_id', $user->id)->first();

        $items = [];
        if ($cart) {
            $items = DB::table('cart_product as cp')
                ->leftJoin('products as p', 'cp.product_id', '=', 'p.product_id')
                ->leftJoin('product_photos as pp', function ($join) {
                    $join->on('p.product_id', '=', 'pp.product_id')
                        ->where('pp.is_primary', true);
                })
                ->where('cp.cart_id', $cart->cart_id)
                ->select('cp.quantity', 'p.product_name', 'p.retail_price', 'pp.photo_url')
                ->get();
        }

        return view('customer.cart.index', compact('cart', 'items'));
    }
}
