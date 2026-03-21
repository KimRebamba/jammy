<?php

namespace App\Charts;

use Illuminate\Support\Facades\DB;

class SalesCharts
{
    public static function yearlySales(): array
    {
        $yearlyRaw = DB::table('orders as o')
            ->join('product_order as po', 'o.order_id', '=', 'po.order_id')
            ->where('o.order_status', 'completed')
            ->select(
                DB::raw('YEAR(o.date_ordered) as year'),
                DB::raw('SUM(po.quantity * po.unit_price) as total')
            )
            ->groupBy(DB::raw('YEAR(o.date_ordered)'))
            ->orderBy('year')
            ->pluck('total', 'year')
            ->toArray();

        return [
            'labels' => array_keys($yearlyRaw),
            'data' => array_values($yearlyRaw),
        ];
    }

    public static function rangeSales(string $startDate, string $endDate): array
    {
        $rangeRaw = DB::table('orders as o')
            ->join('product_order as po', 'o.order_id', '=', 'po.order_id')
            ->where('o.order_status', 'completed')
            ->whereDate('o.date_ordered', '>=', $startDate)
            ->whereDate('o.date_ordered', '<=', $endDate)
            ->select(
                DB::raw('DATE(o.date_ordered) as order_date'),
                DB::raw('SUM(po.quantity * po.unit_price) as total')
            )
            ->groupBy(DB::raw('DATE(o.date_ordered)'))
            ->orderBy('order_date')
            ->pluck('total', 'order_date')
            ->toArray();

        return [
            'labels' => array_keys($rangeRaw),
            'data' => array_values($rangeRaw),
        ];
    }

    public static function productSales(): array
    {
        $productSales = DB::table('orders as o')
            ->join('product_order as po', 'o.order_id', '=', 'po.order_id')
            ->join('products as p', 'po.product_id', '=', 'p.product_id')
            ->where('o.order_status', 'completed')
            ->select(
                'p.product_name',
                DB::raw('SUM(po.quantity * po.unit_price) as total')
            )
            ->groupBy('p.product_name')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'labels' => $productSales->pluck('product_name')->toArray(),
            'data' => $productSales->pluck('total')->toArray(),
        ];
    }
}
