<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;

class ProductsDataTable
{
    public static function get()
    {
        $products = DB::table('products as p')
            ->leftJoin('brands as b', 'p.brand_id', '=', 'b.brand_id')
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.category_id')
            ->select(
                'p.product_id as ID',
                'p.product_name as Product',
                'b.brand_name as Brand',
                'c.category_name as Category',
                'p.model as Model',
                'p.retail_price as Price',
                'p.stock_level as Stock'
            )
            ->orderBy('p.product_id')
            ->get();

        foreach ($products as $product) {
            $photo = DB::table('product_photos')
                ->where('product_id', $product->ID)
                ->where('is_primary', 1)
                ->first();

            $product->Image = $photo ? $photo->photo_url : null;
        }

        return $products;
    }
}
