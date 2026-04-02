<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class ProductsDataTable extends DataTable
{
    public function dataTable($query)
    {
		
		return datatables()->collection($query)
            ->addColumn('select', function ($row) {
                return '<input type="checkbox" name="selected_ids[]" value="' . e($row->id) . '" class="rounded border-slate-600 bg-slate-900">';
            })
            ->addColumn('image', function ($row) {
                if (!$row->image) {
                    return '<span class="text-slate-500 text-xs">N/A</span>';
                }

                $src = asset($row->image);

                return '<img src="' . e($src) . '" alt="Product" class="w-12 h-12 rounded border border-slate-700/80 object-cover">';
            })
            ->addColumn('actions', function ($row) {
                $viewUrl = url('/admin/products/' . $row->id);
                $editUrl = url('/admin/products/' . $row->id . '/edit');

                return '<a href="' . e($viewUrl) . '" class="text-amber-300 hover:text-amber-200 text-xs">View</a>
                        <span class="text-slate-600">|</span>
                        <a href="' . e($editUrl) . '" class="text-amber-300 hover:text-amber-200 text-xs">Edit</a>';
            })
            ->rawColumns(['select', 'image', 'actions']);
    }

    public function query()
    {
        $productsQuery = DB::table('products as p')
            ->leftJoin('brands as b', 'p.brand_id', '=', 'b.brand_id')
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.category_id')
            ->select(
                'p.product_id as id',
                'p.product_name as product',
                'b.brand_name as brand',
                'c.category_name as category',
                'p.model as model',
                'p.retail_price as price',
                'p.stock_level as stock',
                'p.deleted_at'
            )
            ->orderBy('p.product_id');

        $deletedFilter = request('deleted');

        if ($deletedFilter === 'only') {
            $productsQuery->whereNotNull('p.deleted_at');
        } elseif ($deletedFilter !== 'with') {
            $productsQuery->whereNull('p.deleted_at');
        }

        $products = $productsQuery->get();

        foreach ($products as $product) {
            $photo = DB::table('product_photos')
                ->where('product_id', $product->id)
                ->where('is_primary', 1)
                ->first();

            $product->image = $photo ? $photo->photo_url : null;
        }

        return collect($products);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->parameters([
                'paging' => true,
                'searching' => true,
                'info' => true,
                'lengthChange' => true,
                'pageLength' => 10,
                'dom' => 'rt<"dt-footer"lip>',
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('select')
                ->exportable(false)
                ->printable(false)
                ->title('Select')
                ->width(60),
            Column::make('id')->title('ID'),
            Column::computed('image')
                ->exportable(false)
                ->printable(false)
                ->title('Image')
                ->width(80),
            Column::make('product')->title('Product'),
            Column::make('brand')->title('Brand'),
            Column::make('category')->title('Category'),
            Column::make('price')->title('Price'),
            Column::make('stock')->title('Stock'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }
}
