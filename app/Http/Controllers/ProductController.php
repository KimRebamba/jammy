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

    public function productsForBrandAndCategory(Request $request, $categoryId, $brandId)
    {
        $category = DB::table('categories')->where('category_id', $categoryId)->first();
        $brand = DB::table('brands')->where('brand_id', $brandId)->first();
        if (!$category || !$brand) {
            return redirect('/shop')->with('error', 'Category or Brand not found');
        }

        $query = DB::table('products as p')
            ->where('p.category_id', $categoryId)
            ->where('p.brand_id', $brandId)
            ->where('p.is_active', 1)
            ->select('p.product_id', 'p.product_name', 'p.retail_price');

        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');

        if ($minPrice !== null && $minPrice !== '') {
            $query->where('p.retail_price', '>=', (float) $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('p.retail_price', '<=', (float) $maxPrice);
        }

        $products = $query
            ->orderBy('p.product_name')
            ->get();

        foreach ($products as $product) {
            $photo = DB::table('product_photos')
                ->where('product_id', $product->product_id)
                ->where('is_primary', 1)
                ->first();

            $product->photo_url = $photo ? $photo->photo_url : null;
        }

        return view('customer.catalog.products', compact('category', 'brand', 'products'));
    }

    public function productShow($productId)
    {
        $product = DB::table('products as p')
            ->leftJoin('brands as b', 'p.brand_id', '=', 'b.brand_id')
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.category_id')
            ->where('p.product_id', $productId)
            ->where('p.is_active', 1)
            ->select(
                'p.*',
                'b.brand_name',
                'c.category_name'
            )
            ->first();

        if (!$product) {
            return redirect('/shop')->with('error', 'Product not found');
        }

        $primaryPhoto = DB::table('product_photos')
            ->where('product_id', $productId)
            ->where('is_primary', 1)
            ->first();

        $product->primary_photo = $primaryPhoto ? $primaryPhoto->photo_url : null;

        $photos = DB::table('product_photos')
            ->where('product_id', $productId)
            ->orderByDesc('is_primary')
            ->orderBy('sort_order')
            ->get();

        return view('customer.catalog.product_show', compact('product', 'photos'));
    }
}
