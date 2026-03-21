<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class CategoriesDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()->query($query)
            ->addColumn('select', function ($row) {
                return '<input type="checkbox" name="selected_ids[]" value="' . e($row->id) . '" class="rounded border-slate-600 bg-slate-900">';
            })
            ->addColumn('image', function ($row) {
                if (!$row->image) {
                    return '<span class="text-slate-500 text-xs">N/A</span>';
                }

                $src = asset($row->image);

                return '<img src="' . e($src) . '" alt="Category" class="w-16 h-16 rounded border border-slate-700/80 object-cover">';
            })
            ->addColumn('active_text', function ($row) {
                return $row->active ? 'Yes' : 'No';
            })
            ->addColumn('actions', function ($row) {
                $viewUrl = url('/admin/categories/' . $row->id);
                $editUrl = url('/admin/categories/' . $row->id . '/edit');
                $deleteUrl = url('/admin/categories/' . $row->id . '/delete');

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
            ->rawColumns(['select', 'image', 'actions']);
    }

    public function query()
    {
        $query = DB::table('categories')
            ->select(
                'category_id as id',
                'photo_url as image',
                'category_name as category',
                'is_active as active',
                'deleted_at'
            )
            ->orderBy('category_id');

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
            ->setTableId('categories-table')
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
            Column::computed('image')
                ->exportable(false)
                ->printable(false)
                ->title('Image')
                ->width(80),
            Column::make('category')->title('Category'),
            Column::computed('active_text')->title('Active'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(140)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }
}
