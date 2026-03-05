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
                ->select('cp.cart_product_id', 'cp.product_id', 'cp.quantity', 'p.product_name', 'p.retail_price', 'pp.photo_url')
                ->get();
        }

        return view('customer.cart.index', compact('cart', 'items'));
    }

    public function add(Request $request, $productId)
    {
        $product = DB::table('products')->where('product_id', $productId)->first();

        if (!$product || $product->stock_level < 1) {
                return redirect('/shop')->with('error', 'Product is out of stock');
         }

        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = DB::table('products')
            ->where('product_id', $productId)
            ->where('is_active', 1)
            ->first();

        if (!$product) {
            return redirect('/shop')->with('error', 'Product not found');
        }

        $cart = DB::table('cart')->where('user_id', $user->id)->first();
        if (!$cart) {
            $cartId = DB::table('cart')->insertGetId([
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $cart = DB::table('cart')->where('cart_id', $cartId)->first();
        }

        $existing = DB::table('cart_product')
            ->where('cart_id', $cart->cart_id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            DB::table('cart_product')
                ->where('cart_product_id', $existing->cart_product_id)
                ->update([
                    'quantity' => $existing->quantity + $data['quantity'],
                ]);
        } else {
            DB::table('cart_product')->insert([
                'cart_id' => $cart->cart_id,
                'product_id' => $productId,
                'quantity' => $data['quantity'],
            ]);
        }

        return back()->with('success', 'Product added to cart');
    }

    public function delete($id)
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $cart = DB::table('cart')->where('user_id', $user->id)->first();
        if (!$cart) {
            return redirect('/cart')->with('error', 'Cart not found');
        }

        $item = DB::table('cart_product')
            ->where('cart_product_id', $id)
            ->where('cart_id', $cart->cart_id)
            ->first();

        if (!$item) {
            return redirect('/cart')->with('error', 'Cart item not found');
        }

        DB::table('cart_product')->where('cart_product_id', $id)->delete();

        return redirect('/cart')->with('success', 'Item removed from cart');
    }

    public function increase($id)
    {

        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $cart = DB::table('cart')->where('user_id', $user->id)->first();
        
        if (!$cart) {
            return redirect('/cart')->with('error', 'Cart not found');
        }

        $item = DB::table('cart_product')
            ->where('cart_product_id', $id)
            ->where('cart_id', $cart->cart_id)
            ->first();

        $product = DB::table('cart_product as cp')
            ->join('products as p', 'cp.product_id', '=', 'p.product_id')
            ->where('cp.cart_product_id', $id)
            ->where('cp.cart_id', $cart->cart_id)
            ->select('p.stock_level as stock_level', 'cp.quantity as cart_quantity')
            ->first();
        
        if ( ($product->cart_quantity + 1) > $product->stock_level) {
            return redirect('/cart')->with('error', 'Cannot increase quantity beyond stock level');
        }

        if (!$item) {
            return redirect('/cart')->with('error', 'Cart item not found');
        }

        DB::table('cart_product')
            ->where('cart_product_id', $id)
            ->update([
                'quantity' => $item->quantity + 1,
            ]);

        return redirect('/cart')->with('success', 'Quantity updated');
    }

    public function decrease($id)
    {

        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $cart = DB::table('cart')->where('user_id', $user->id)->first();
        if (!$cart) {
            return redirect('/cart')->with('error', 'Cart not found');
        }

        $item = DB::table('cart_product')
            ->where('cart_product_id', $id)
            ->where('cart_id', $cart->cart_id)
            ->first();

        if (!$item) {
            return redirect('/cart')->with('error', 'Cart item not found');
        }

        if ($item->quantity <= 1) {
            DB::table('cart_product')->where('cart_product_id', $id)->delete();
            return redirect('/cart')->with('success', 'Item removed from cart');
        }

        if ($item->quantity > 1) {
            DB::table('cart_product')
                ->where('cart_product_id', $id)
                ->update([
                    'quantity' => $item->quantity - 1,
                ]);
        }

        return redirect('/cart')->with('success', 'Quantity updated');
    }

    public function buyForm(Request $request)
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $cart = DB::table('cart')->where('user_id', $user->id)->first();
        if (!$cart) {
            return redirect('/cart')->with('error', 'Cart not found');
        }

        $data = $request->validate([
            'items' => 'required|array',
            'items.*' => 'integer',
        ]);

        $items = DB::table('cart_product as cp')
            ->join('products as p', 'cp.product_id', '=', 'p.product_id')
            ->where('cp.cart_id', $cart->cart_id)
            ->whereIn('cp.cart_product_id', $data['items'])
            ->select('cp.cart_product_id', 'cp.quantity', 'p.product_name', 'p.retail_price as retail_price')
            ->get();

        if ($items->isEmpty()) {
            return redirect('/cart')->with('error', 'No valid items selected');
        }

        $account = DB::table('accounts')->where('user_id', $user->id)->first();
        $paymentOptions = ['GCash', 'Maya', 'Cash on Delivery'];

        return view('customer.cart.buy', compact('items', 'account', 'paymentOptions'));
    }

    public function buyConfirm(Request $request)
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $cart = DB::table('cart')->where('user_id', $user->id)->first();
        if (!$cart) {
            return redirect('/cart')->with('error', 'Cart not found');
        }

        $data = $request->validate([
            'items' => 'required|array',
            'items.*' => 'integer',
            'payment_option' => 'required|in:GCash,Maya,Cash on Delivery',
        ]);

        $items = DB::table('cart_product as cp')
            ->join('products as p', 'cp.product_id', '=', 'p.product_id')
            ->where('cp.cart_id', $cart->cart_id)
            ->whereIn('cp.cart_product_id', $data['items'])
            ->select('cp.cart_product_id', 'cp.product_id', 'cp.quantity', 'p.retail_price', 'p.stock_level as stock_level')
            ->get();

        foreach ($items as $item) {
            if ($item->stock_level < $item->quantity) {
                DB::table('cart_product')
                    ->where('cart_product_id', $item->cart_product_id)
                    ->update(['quantity' => $item->stock_level]);
                return redirect('/cart')->with('error', 'One or more items exceed stock level');
            }
        }

        if ($items->isEmpty()) {
            return redirect('/cart')->with('error', 'No valid items selected');
        }

        DB::beginTransaction();
        try {
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => $user->id,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'payment_option' => $data['payment_option'],
                'delivery_fee' => 50.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($items as $item) {
                DB::table('product_order')->insert([
                    'order_id' => $orderId,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->retail_price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('cart_product')->where('cart_product_id', $item->cart_product_id)->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/cart')->with('error', 'Failed to place order');
        }

        return redirect('/orders')->with('success', 'Order placed successfully');
    }
}
