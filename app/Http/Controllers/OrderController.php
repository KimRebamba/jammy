<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $orders = DB::table('orders as o')
            ->leftJoin('product_order as po', 'o.order_id', '=', 'po.order_id')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->where('o.user_id', $user->id)
            ->select(
                'o.order_id',
                'o.date_ordered',
                'o.payment_status',
                'o.order_status',
                'o.delivery_fee',
                DB::raw('GROUP_CONCAT(CONCAT(p.product_name, " x", po.quantity) SEPARATOR ", ") as items')
            )
            ->groupBy('o.order_id', 'o.date_ordered', 'o.payment_status', 'o.order_status', 'o.delivery_fee')
            ->orderBy('o.date_ordered', 'desc')
            ->get();

        return view('customer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $order = DB::table('orders')
            ->where('order_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return redirect('/orders')->with('error', 'Order not found');
        }

        $items = DB::table('product_order as po')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->leftJoin('product_photos as pp', function ($join) {
                $join->on('p.product_id', '=', 'pp.product_id')
                    ->where('pp.is_primary', true);
            })
            ->where('po.order_id', $id)
            ->select('p.product_name', 'po.quantity', 'po.unit_price', 'pp.photo_url')
            ->get();

        return view('customer.orders.show', compact('order', 'items'));
    }
}
