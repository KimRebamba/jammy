<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class ReturnsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()->query($query)
            ->addColumn('select', function ($row) {
                return '<input type="checkbox" name="selected_ids[]" value="' . e($row->id) . '" class="rounded border-slate-600 bg-slate-900">';
            })
            ->addColumn('reason_short', function ($row) {
                $reason = $row->reason ?? '';
                if (mb_strlen($reason) > 50) {
                    $reason = mb_substr($reason, 0, 50) . '...';
                }
                return e($reason);
            })
            ->addColumn('actions', function ($row) {
                $viewUrl = url('/admin/returns/' . $row->id);
                $editUrl = url('/admin/returns/' . $row->id . '/edit');
                $deleteUrl = url('/admin/returns/' . $row->id . '/delete');

                $csrf = csrf_field();

                return '<a href="' . e($viewUrl) . '" class="text-amber-300 hover:text-amber-200 text-xs">View</a>
                        <span class="text-slate-600">|</span>
                        <a href="' . e($editUrl) . '" class="text-amber-300 hover:text-amber-200 text-xs">Edit</a>
                        <span class="text-slate-600">|</span>
                        <form action="' . e($deleteUrl) . '" method="post" class="inline">' .
                            $csrf .
                            '<button type="submit" class="text-red-300 hover:text-red-200 text-xs">Delete</button>
                        </form>';
            })
            ->rawColumns(['select', 'actions']);
    }

    public function query()
    {
        $query = DB::table('order_return as r')
            ->leftJoin('orders as o', 'r.order_id', '=', 'o.order_id')
            ->select(
                'r.order_return_id as id',
                'o.order_id as order_id',
                'r.reason',
                'r.cond as condition',
                'r.return_status as status',
                'r.refund_amount as refund',
                'r.deleted_at'
            )
            ->orderBy('r.order_return_id');

        $deletedFilter = request('deleted');

        if ($deletedFilter === 'only') {
            $query->whereNotNull('r.deleted_at');
        } elseif ($deletedFilter !== 'with') {
            $query->whereNull('r.deleted_at');
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('returns-table')
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
            Column::make('order_id')->title('Order ID'),
            Column::computed('reason_short')->title('Reason'),
            Column::make('status')->title('Status'),
            Column::make('refund')->title('Refund'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(140)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }
}
