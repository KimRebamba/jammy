<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class OrdersDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()->query($query)
            ->addColumn('select', function ($row) {
                return '<input type="checkbox" name="selected_ids[]" value="' . e($row->id) . '" class="rounded border-slate-600 bg-slate-900">';
            })
            ->addColumn('items_short', function ($row) {
                $items = $row->items ?? '';
                return strlen($items) > 50 ? substr($items, 0, 50) . '...' : $items;
            })
            ->addColumn('actions', function ($row) {
                $viewUrl = url('/admin/orders/' . $row->id);
                $editUrl = url('/admin/orders/' . $row->id . '/edit');

                return '<a href="' . e($viewUrl) . '" class="text-amber-300 hover:text-amber-200 text-xs">View</a>
                        <span class="text-slate-600">|</span>
                        <a href="' . e($editUrl) . '" class="text-amber-300 hover:text-amber-200 text-xs">Edit</a>';
            })
            ->rawColumns(['select', 'actions']);
    }

    public function query()
    {
        $query = DB::table('orders as o')
            ->leftJoin('accounts as a', 'o.user_id', '=', 'a.user_id')
            ->leftJoin('product_order as po', 'o.order_id', '=', 'po.order_id')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->select(
                'o.order_id as id',
                'a.username as customer',
                'o.payment_status as payment',
                'o.order_status as status',
                'o.delivery_fee as delivery',
                'o.date_ordered as date',
                DB::raw('GROUP_CONCAT(CONCAT(p.product_name, " x", po.quantity) SEPARATOR ", ") as items')
            )
            ->groupBy('o.order_id', 'a.username', 'o.payment_status', 'o.order_status', 'o.delivery_fee', 'o.date_ordered')
            ->orderBy('o.order_id');

        $deletedFilter = request('deleted');

        if ($deletedFilter === 'only') {
            $query->whereNotNull('o.deleted_at');
        } elseif ($deletedFilter !== 'with') {
            $query->whereNull('o.deleted_at');
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orders-table')
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
            Column::make('customer')->title('Customer'),
            Column::make('payment')->title('Payment'),
            Column::make('status')->title('Status'),
            Column::make('date')->title('Date'),
            Column::computed('items_short')->title('Items'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }
}
