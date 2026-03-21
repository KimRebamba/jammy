<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class AccountsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()->query($query)
            ->addColumn('select', function ($row) {
                return '<input type="checkbox" name="selected_ids[]" value="' . e($row->id) . '" class="rounded border-slate-600 bg-slate-900">';
            })
            ->addColumn('picture', function ($row) {
                if (!$row->picture) {
                    return '<span class="text-slate-500 text-xs">N/A</span>';
                }

                $src = asset($row->picture);

                return '<img src="' . e($src) . '" alt="Profile" class="w-10 h-10 rounded-full border border-slate-700/80 object-cover">';
            })
            ->addColumn('active_badge', function ($row) {
                if (!empty($row->deleted_at)) {
                    return '<span class="inline-flex items-center px-2 py-0.5 rounded-full bg-red-500/20 text-red-300 text-xs">Deleted</span>';
                }

                if ($row->active) {
                    return '<span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-xs">Active</span>';
                }

                return '<span class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-700/40 text-slate-300 text-xs">Inactive</span>';
            })
            ->addColumn('actions', function ($row) {
                $viewUrl = url('/admin/accounts/' . $row->id);
                $editUrl = url('/admin/accounts/' . $row->id . '/edit');

                return '<a href="' . e($viewUrl) . '" class="text-amber-300 hover:text-amber-200 text-xs">View</a>
                        <span class="text-slate-600">|</span>
                        <a href="' . e($editUrl) . '" class="text-amber-300 hover:text-amber-200 text-xs">Edit</a>';
            })
            ->rawColumns(['select', 'picture', 'active_badge', 'actions']);
    }

    public function query()
    {
        $query = DB::table('accounts')
            ->select(
                'user_id as id',
                'username',
                'email',
                'profile_photo_url as picture',
                'role',
                'is_active as active',
                'email_verified_at as verified_at',
                'deleted_at'
            )
            ->orderBy('user_id');

        $deletedFilter = request('deleted');

        if ($deletedFilter === 'only') {
            $query->whereNotNull('deleted_at');
        } elseif ($deletedFilter !== 'with') {
            $query->whereNull('deleted_at');
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('accounts-table')
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
            Column::computed('picture')
                ->exportable(false)
                ->printable(false)
                ->title('Picture')
                ->width(80),
            Column::make('username')->title('Username'),
            Column::make('email')->title('Email'),
            Column::make('role')->title('Role'),
            Column::computed('active_badge')->title('Active'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }
}
