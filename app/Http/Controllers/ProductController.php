<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function categories()
    {
        $categories = DB::table('categories')
            ->where('is_active', 1)
            ->orderBy('category_name')
            ->get();

        return view('customer.catalog.categories', compact('categories'));
    }

    public function brandsForCategory($categoryId)
    {
        $category = DB::table('categories')->where('category_id', $categoryId)->first();
        if (!$category) {
            return redirect('/shop')->with('error', 'Category not found');
        }

        $brands = DB::table('brands as b')
            ->join('products as p', 'p.brand_id', '=', 'b.brand_id')
            ->where('p.category_id', $categoryId)
            ->where('p.is_active', 1)
            ->select('b.brand_id', 'b.brand_name', 'b.logo_url')
            ->distinct()
            ->orderBy('b.brand_name')
            ->get();

        return view('customer.catalog.brands', compact('category', 'brands'));
    }

    public function productsForBrandAndCategory($categoryId, $brandId)
    {
        $category = DB::table('categories')->where('category_id', $categoryId)->first();
        $brand = DB::table('brands')->where('brand_id', $brandId)->first();
        if (!$category || !$brand) {
            return redirect('/shop')->with('error', 'Category or Brand not found');
        }

        $products = DB::table('products as p')
            ->leftJoin('product_photos as pp', function ($join) {
                $join->on('p.product_id', '=', 'pp.product_id')
                    ->where('pp.is_primary', true);
            })
            ->where('p.category_id', $categoryId)
            ->where('p.brand_id', $brandId)
            ->where('p.is_active', 1)
            ->select('p.product_id', 'p.product_name', 'p.retail_price', 'pp.photo_url')
            ->orderBy('p.product_name')
            ->get();

        return view('customer.catalog.products', compact('category', 'brand', 'products'));
    }

    public function productShow($productId)
    {
        $product = DB::table('products as p')
            ->leftJoin('brands as b', 'p.brand_id', '=', 'b.brand_id')
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.category_id')
            ->leftJoin('product_photos as pp', function ($join) {
                $join->on('p.product_id', '=', 'pp.product_id')
                    ->where('pp.is_primary', true);
            })
            ->where('p.product_id', $productId)
            ->where('p.is_active', 1)
            ->select(
                'p.*',
                'b.brand_name',
                'c.category_name',
                'pp.photo_url as primary_photo'
            )
            ->first();

        if (!$product) {
            return redirect('/shop')->with('error', 'Product not found');
        }

        $photos = DB::table('product_photos')
            ->where('product_id', $productId)
            ->orderByDesc('is_primary')
            ->orderBy('sort_order')
            ->get();

        return view('customer.catalog.product_show', compact('product', 'photos'));
    }
}
