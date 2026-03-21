<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $productName = trim((string) ($row['product_name'] ?? ''));

            if ($productName === '') {
                continue;
            }

            $brandId = null;
            if (isset($row['brand_id']) && $row['brand_id'] !== '') {
                $candidateBrandId = (int) $row['brand_id'];
                if ($candidateBrandId > 0 && DB::table('brands')->where('brand_id', $candidateBrandId)->exists()) {
                    $brandId = $candidateBrandId;
                }
            }

            $model = isset($row['model']) ? trim((string) $row['model']) : null;

            $categoryId = null;
            if (isset($row['category_id']) && $row['category_id'] !== '') {
                $candidateCategoryId = (int) $row['category_id'];
                if ($candidateCategoryId > 0 && DB::table('categories')->where('category_id', $candidateCategoryId)->exists()) {
                    $categoryId = $candidateCategoryId;
                }
            }

            $retailPrice = 0;
            if (isset($row['retail_price']) && is_numeric($row['retail_price'])) {
                $retailPrice = (float) $row['retail_price'];
            }

            $costPrice = 0;
            if (isset($row['cost_price']) && is_numeric($row['cost_price'])) {
                $costPrice = (float) $row['cost_price'];
            }

            $description = isset($row['description']) ? trim((string) $row['description']) : null;

            $isActive = 1;
            if (isset($row['is_active']) && $row['is_active'] !== '') {
                $isActive = ((int) $row['is_active'] === 1) ? 1 : 0;
            }

            $stockLevel = 0;
            if (isset($row['stock_level']) && is_numeric($row['stock_level'])) {
                $stockLevel = (int) $row['stock_level'];
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
        }
    }
}
