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
        // Load orders for the current customer
        $orders = DB::table('orders')
            ->where('user_id', $user->id)
            ->orderBy('date_ordered', 'desc')
            ->get();

        if ($orders->isEmpty()) {
            return view('customer.orders.index', compact('orders'));
        }

        // Load items for these orders and build a simple items string per order
        $orderIds = $orders->pluck('order_id')->all();

        $lines = DB::table('product_order as po')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->whereIn('po.order_id', $orderIds)
            ->select('po.order_id', 'p.product_name', 'po.quantity')
            ->orderBy('po.order_id')
            ->get();

        $itemsByOrder = [];
        foreach ($lines as $line) {
            if (!isset($itemsByOrder[$line->order_id])) {
                $itemsByOrder[$line->order_id] = [];
            }
            $itemsByOrder[$line->order_id][] = $line->product_name . ' x' . $line->quantity;
        }

        foreach ($orders as $order) {
            $order->items = isset($itemsByOrder[$order->order_id])
                ? implode(', ', $itemsByOrder[$order->order_id])
                : '';
        }

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

    public function cancel($id)
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

        if (in_array($order->order_status, ['completed', 'cancelled', 'returned'])) {
            return redirect('/orders')->with('error', 'This order cannot be cancelled');
        }

        DB::table('orders')
            ->where('order_id', $id)
            ->update([
                'order_status' => 'cancelled',
                'updated_at' => now(),
            ]);

        return redirect('/orders')->with('success', 'Order cancelled successfully');
    }

    public function returnForm($id)
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

        if (in_array($order->order_status, ['processing', 'cancelled', 'returned', 'pending', ])) {
            return redirect('/orders')->with('error', 'This order cannot be returned');
        }

        $existingReturn = DB::table('order_return')
            ->where('order_id', $id)
            ->first();

        if ($existingReturn) {
            return redirect('/orders')->with('error', 'Return already requested for this order');
        }

        $items = DB::table('product_order as po')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->where('po.order_id', $id)
            ->select('p.product_name', 'po.quantity')
            ->get();

        $conditions = ['new', 'opened', 'damaged', 'other'];

        return view('customer.orders.return', compact('order', 'items', 'conditions'));
    }

    public function returnStore(Request $request, $id)
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

        if ($order->order_status !== 'completed') {
            return redirect('/orders')->with('error', 'This order cannot be returned');
        }

        $existingReturn = DB::table('order_return')
            ->where('order_id', $id)
            ->first();

        if ($existingReturn) {
            return redirect('/orders')->with('error', 'Return already requested for this order');
        }

        $data = $request->validate([
            'reason' => 'nullable|string',
            'cond' => 'required|in:new,opened,damaged,other',
        ]);

        DB::table('order_return')->insert([
            'order_id' => $id,
            'reason' => $data['reason'] ?? null,
            'cond' => $data['cond'],
            'return_status' => 'requested',
            'refund_amount' => 0,
            'processed_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')
            ->where('order_id', $id)
            ->update([
                'order_status' => 'requested_refund',
                'updated_at' => now(),
            ]);

        return redirect('/orders')->with('success', 'Return request submitted');
    }

    public function reviewForm($id)
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

        if ($order->order_status !== 'completed') {
            return redirect('/orders')->with('error', 'Only completed orders can be reviewed');
        }

        $items = DB::table('product_order as po')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->leftJoin('product_review as pr', function ($join) use ($user) {
                $join->on('pr.product_order_id', '=', 'po.product_order_id')
                    ->where('pr.user_id', $user->id);
            })
            ->where('po.order_id', $id)
            ->whereNull('pr.review_id')
            ->select('po.product_order_id', 'p.product_name', 'po.quantity')
            ->get();

        if ($items->isEmpty()) {
            return redirect('/reviews')->with('error', 'All items in this order already have reviews');
        }

        return view('customer.orders.review', compact('order', 'items'));
    }

    public function reviewStore(Request $request, $id)
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

        if ($order->order_status !== 'completed') {
            return redirect('/orders')->with('error', 'Only completed orders can be reviewed');
        }

        $data = $request->validate([
            'product_order_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'review_title' => 'nullable|string|max:255',
            'review_text' => 'nullable|string',
        ]);

        $line = DB::table('product_order as po')
            ->leftJoin('product_review as pr', function ($join) use ($user) {
                $join->on('pr.product_order_id', '=', 'po.product_order_id')
                    ->where('pr.user_id', $user->id);
            })
            ->where('po.product_order_id', $data['product_order_id'])
            ->where('po.order_id', $id)
            ->select('po.product_order_id', 'pr.review_id')
            ->first();

        if (!$line) {
            return redirect('/orders')->with('error', 'Invalid product selection');
        }

        if ($line->review_id) {
            return redirect('/reviews')->with('error', 'You have already reviewed this item');
        }

        DB::table('product_review')->insert([
            'product_order_id' => $data['product_order_id'],
            'user_id' => $user->id,
            'rating' => $data['rating'],
            'review_title' => $data['review_title'] ?? null,
            'review_text' => $data['review_text'] ?? null,
            'is_verified' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/reviews')->with('success', 'Review created successfully');
    }
}
