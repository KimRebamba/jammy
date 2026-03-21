<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;

class ReviewsDataTable
{
    public static function get()
    {
        return DB::table('product_review as pr')
            ->leftJoin('accounts as a', 'pr.user_id', '=', 'a.user_id')
            ->leftJoin('product_order as po', 'pr.product_order_id', '=', 'po.product_order_id')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->select(
                'pr.review_id as ID',
                'a.username as Customer',
                'p.product_name as Product',
                'pr.rating as Rating',
                'pr.is_verified as Verified'
            )
            ->orderBy('pr.review_id')
            ->get();
    }
}
