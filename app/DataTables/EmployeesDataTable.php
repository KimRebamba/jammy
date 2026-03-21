<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class EmployeesDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()->query($query)
            ->addColumn('select', function ($row) {
                return '<input type="checkbox" name="selected_ids[]" value="' . e($row->id) . '" class="rounded border-slate-600 bg-slate-900">';
            })
            ->addColumn('actions', function ($row) {
                $viewUrl = url('/admin/employees/' . $row->id);
                $editUrl = url('/admin/employees/' . $row->id . '/edit');
                $deleteUrl = url('/admin/employees/' . $row->id . '/delete');

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
        $query = DB::table('employees as e')
            ->leftJoin('positions as p', 'e.current_position_id', '=', 'p.position_id')
            ->select(
                'e.emp_id as id',
                DB::raw("CONCAT(e.first_name,' ',e.last_name) as name"),
                'p.position_name as position',
                'e.employment_status as status',
                'e.hire_date as hired',
                'e.deleted_at'
            )
            ->orderBy('e.emp_id');

        $deletedFilter = request('deleted');

        if ($deletedFilter === 'only') {
            $query->whereNotNull('e.deleted_at');
        } elseif ($deletedFilter !== 'with') {
            $query->whereNull('e.deleted_at');
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('employees-table')
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
            Column::make('name')->title('Name'),
            Column::make('position')->title('Position'),
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
