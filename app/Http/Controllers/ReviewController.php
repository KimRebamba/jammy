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
}
