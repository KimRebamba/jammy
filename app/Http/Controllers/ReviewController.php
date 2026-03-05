<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index()
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $reviews = DB::table('product_review as pr')
            ->leftJoin('product_order as po', 'pr.product_order_id', '=', 'po.product_order_id')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->where('pr.user_id', $user->id)
            ->select('pr.*', 'p.product_name')
            ->orderBy('pr.created_at', 'desc')
            ->get();

        return view('customer.reviews.index', compact('reviews'));
    }

    public function edit($id)
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $review = DB::table('product_review as pr')
            ->leftJoin('product_order as po', 'pr.product_order_id', '=', 'po.product_order_id')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->where('pr.review_id', $id)
            ->where('pr.user_id', $user->id)
            ->select('pr.*', 'p.product_name')
            ->first();

        if (!$review) {
            return redirect('/reviews')->with('error', 'Review not found');
        }

        return view('customer.reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $review = DB::table('product_review')
            ->where('review_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$review) {
            return redirect('/reviews')->with('error', 'Review not found');
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_title' => 'nullable|string|max:255',
            'review_text' => 'nullable|string',
        ]);

        DB::table('product_review')
            ->where('review_id', $id)
            ->update([
                'rating' => $data['rating'],
                'review_title' => $data['review_title'] ?? null,
                'review_text' => $data['review_text'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect('/reviews')->with('success', 'Review updated successfully');
    }

    public function delete($id)
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $review = DB::table('product_review')
            ->where('review_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$review) {
            return redirect('/reviews')->with('error', 'Review not found');
        }

        DB::table('product_review')->where('review_id', $id)->delete();

        return redirect('/reviews')->with('success', 'Review deleted successfully');
    }
}
