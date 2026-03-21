<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;

class ProductImport
{
    public function importFromCsv(string $path): int
    {
        $handle = fopen($path, 'r');

        if ($handle === false) {
            return 0;
        }

        $header = fgetcsv($handle, 0, ',');
        if ($header === false) {
            fclose($handle);
            return 0;
        }

        $indexes = [];
        foreach ($header as $index => $name) {
            $key = strtolower(trim($name));
            $indexes[$key] = $index;
        }

        $count = 0;

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            if (empty($row)) {
                continue;
            }

            $productName = isset($indexes['product_name']) && isset($row[$indexes['product_name']])
                ? trim($row[$indexes['product_name']])
                : '';

            if ($productName === '') {
                continue;
            }

            $brandId = null;
            if (isset($indexes['brand_id']) && isset($row[$indexes['brand_id']]) && $row[$indexes['brand_id']] !== '') {
                $candidateBrandId = (int) $row[$indexes['brand_id']];
                if ($candidateBrandId > 0 && DB::table('brands')->where('brand_id', $candidateBrandId)->exists()) {
                    $brandId = $candidateBrandId;
                }
            }

            $model = isset($indexes['model']) && isset($row[$indexes['model']])
                ? trim($row[$indexes['model']])
                : null;

            $categoryId = null;
            if (isset($indexes['category_id']) && isset($row[$indexes['category_id']]) && $row[$indexes['category_id']] !== '') {
                $candidateCategoryId = (int) $row[$indexes['category_id']];
                if ($candidateCategoryId > 0 && DB::table('categories')->where('category_id', $candidateCategoryId)->exists()) {
                    $categoryId = $candidateCategoryId;
                }
            }

            $retailPrice = 0;
            if (isset($indexes['retail_price']) && isset($row[$indexes['retail_price']]) && is_numeric($row[$indexes['retail_price']])) {
                $retailPrice = (float) $row[$indexes['retail_price']];
            }

            $costPrice = 0;
            if (isset($indexes['cost_price']) && isset($row[$indexes['cost_price']]) && is_numeric($row[$indexes['cost_price']])) {
                $costPrice = (float) $row[$indexes['cost_price']];
            }

            $description = isset($indexes['description']) && isset($row[$indexes['description']])
                ? trim($row[$indexes['description']])
                : null;

            $isActive = 1;
            if (isset($indexes['is_active']) && isset($row[$indexes['is_active']]) && $row[$indexes['is_active']] !== '') {
                $isActive = ((int) $row[$indexes['is_active']] === 1) ? 1 : 0;
            }

            $stockLevel = 0;
            if (isset($indexes['stock_level']) && isset($row[$indexes['stock_level']]) && is_numeric($row[$indexes['stock_level']])) {
                $stockLevel = (int) $row[$indexes['stock_level']];
            }

            DB::table('products')->insert([
                'product_name' => $productName,
                'brand_id' => $brandId,
                'category_id' => $categoryId,
                'model' => $model,
                'retail_price' => $retailPrice,
                'cost_price' => $costPrice,
                'description' => $description,
                'is_active' => $isActive,
                'stock_level' => $stockLevel,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $count++;
        }

        fclose($handle);

        return $count;
    }
}
