<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class ReviewsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()->query($query)
            ->addColumn('select', function ($row) {
                return '<input type="checkbox" name="selected_ids[]" value="' . e($row->id) . '" class="rounded border-slate-600 bg-slate-900">';
            })
            ->addColumn('verified_text', function ($row) {
                return $row->verified ? 'Yes' : 'No';
            })
            ->addColumn('actions', function ($row) {
                $viewUrl = url('/admin/reviews/' . $row->id);
                $editUrl = url('/admin/reviews/' . $row->id . '/edit');

                return '<a href="' . e($viewUrl) . '" class="text-amber-300 hover:text-amber-200 text-xs">View</a>
                        <span class="text-slate-600">|</span>
                        <a href="' . e($editUrl) . '" class="text-amber-300 hover:text-amber-200 text-xs">Edit</a>';
            })
            ->rawColumns(['select', 'actions']);
    }

    public function query()
    {
        $query = DB::table('product_review as pr')
            ->leftJoin('accounts as a', 'pr.user_id', '=', 'a.user_id')
            ->leftJoin('product_order as po', 'pr.product_order_id', '=', 'po.product_order_id')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->select(
                'pr.review_id as id',
                'a.username as customer',
                'p.product_name as product',
                'pr.rating as rating',
                'pr.is_verified as verified',
                'pr.deleted_at'
            )
            ->orderBy('pr.review_id');

        $deletedFilter = request('deleted');

        if ($deletedFilter === 'only') {
            $query->whereNotNull('pr.deleted_at');
        } elseif ($deletedFilter !== 'with') {
            $query->whereNull('pr.deleted_at');
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('reviews-table')
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
            Column::make('product')->title('Product'),
            Column::make('rating')->title('Rating'),
            Column::computed('verified_text')->title('Verified'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }
}
