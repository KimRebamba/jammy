<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;

class OrdersDataTable
{
    public static function get()
    {
        return DB::table('orders as o')
            ->leftJoin('accounts as a', 'o.user_id', '=', 'a.user_id')
            ->leftJoin('product_order as po', 'o.order_id', '=', 'po.order_id')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->select(
                'o.order_id as ID',
                'a.username as Customer',
                'o.payment_status as Payment',
                'o.order_status as Status',
                'o.delivery_fee as Delivery',
                'o.date_ordered as Date',
                DB::raw('GROUP_CONCAT(CONCAT(p.product_name, " x", po.quantity) SEPARATOR ", ") as Items')
            )
            ->groupBy('o.order_id', 'a.username', 'o.payment_status', 'o.order_status', 'o.delivery_fee', 'o.date_ordered')
            ->orderBy('o.order_id')
            ->get();
    }
}
