<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class SalariesDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()->query($query)
            ->addColumn('select', function ($row) {
                return '<input type="checkbox" name="selected_ids[]" value="' . e($row->id) . '" class="rounded border-slate-600 bg-slate-900">';
            })
            ->addColumn('actions', function ($row) {
                $viewUrl = url('/admin/salaries/' . $row->id);
                $editUrl = url('/admin/salaries/' . $row->id . '/edit');
                $deleteUrl = url('/admin/salaries/' . $row->id . '/delete');

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
        $query = DB::table('salaries as s')
            ->leftJoin('employees as e', 's.emp_id', '=', 'e.emp_id')
            ->select(
                's.salary_id as id',
                DB::raw("CONCAT(e.first_name,' ',e.last_name) as employee"),
                's.pay_date as pay_date',
                's.rate_used as rate',
                's.status',
                's.deleted_at'
            )
            ->orderBy('s.pay_date', 'desc');

        $deletedFilter = request('deleted');

        if ($deletedFilter === 'only') {
            $query->whereNotNull('s.deleted_at');
        } elseif ($deletedFilter !== 'with') {
            $query->whereNull('s.deleted_at');
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('salaries-table')
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
            Column::make('employee')->title('Employee'),
            Column::make('pay_date')->title('Pay Date'),
            Column::make('status')->title('Status'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(140)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }
}
