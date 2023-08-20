<?php

namespace Bitex\Admin\DataGrids\Category;

use Illuminate\Support\Facades\DB;
use Bitex\Core\Models\Locale;
use Bitex\UI\DataGrid\DataGrid;

class CategoryDataGrid extends DataGrid
{

    protected $index = 'category_id';

    protected $sortOrder = 'desc';

    protected $locale = 'all';

    protected $itemsPerPage = 15;

    protected $extraFilters = [
        'locales',
    ];

    public function __construct()
    {
        parent::__construct();

//        $this->locale = core()->getRequestedLocaleCode();
    }

    public function prepareQueryBuilder()
    {
        if ($this->locale === 'all') {
            $whereInLocales = Locale::query()->pluck('code')->toArray();
        } else {
            $whereInLocales = [$this->locale];
        }

        $queryBuilder = DB::table('categories as cat')
            ->select(
                'cat.id as category_id',
                'ct.name',
                'ct.name as rr',
                'cat.position',
                'cat.status',
                'ct.locale',
                DB::raw('COUNT(DISTINCT ' . DB::getTablePrefix() . 'pc.product_id) as count')
            )
//            ->whereIn('status', ['1', '2'])
            ->leftJoin('category_translations as ct', function ($leftJoin) use ($whereInLocales) {
                $leftJoin->on('cat.id', '=', 'ct.category_id')
                    ->whereIn('ct.locale', $whereInLocales);
            })
            ->leftJoin('product_categories as pc', 'cat.id', '=', 'pc.category_id')
            ->groupBy('cat.id', 'ct.locale',);


        $this->addFilter('status', 'cat.status');
        $this->addFilter('category_id', 'cat.id');

        $this->setQueryBuilder($queryBuilder);
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'category_id',
            'label'      => "ID",
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);


        $this->addColumn([
            'index'      => 'name',
            'label'      => "Наименование",
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'position',
            'label'      => "Позиция",
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => "Статус",
            'type'       => 'boolean',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
            'closure'    => function ($value) {
                if ($value->status) {
                    return '<span class="badge badge-md badge-success">'. 123 . '</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">'. 321 . '</span>';
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'count',
            'label'      => "Количество",
            'type'       => 'number',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => false,
        ]);
    }

    public function prepareTabFilters()
    {
        $this->addTabFilter([
            'key'       => 'status',
            'type'      => 'pill',
            'condition' => 'eq',
            'values'    => [
                [
                    'name'     => "Все",
                    'isActive' => true,
                    'key'      => 'all',
                ], [
                    'name'     => "ID 1",
                    'isActive' => false,
                    'key'      => '1',
                ], [
                    'name'     => "ID 2",
                    'isActive' => false,
                    'key'      => '2',
                ]
            ]
        ]);

//        $this->addTabFilter([
//            'key'       => 'scheduled',
//            'type'      => 'group',
//            'condition' => 'eq',
//            'values'    => [
//                [
//                    'name'     => 'admin::app.datagrid.filters.yesterday',
//                    'isActive' => false,
//                    'key'      => 'yesterday',
//                ], [
//                    'name'     => 'admin::app.datagrid.filters.today',
//                    'isActive' => false,
//                    'key'      => 'today',
//                ], [
//                    'name'     => 'admin::app.datagrid.filters.tomorrow',
//                    'isActive' => false,
//                    'key'      => 'tomorrow',
//                ], [
//                    'name'     => 'admin::app.datagrid.filters.this-week',
//                    'isActive' => false,
//                    'key'      => 'this_week',
//                ], [
//                    'name'     => 'admin::app.datagrid.filters.this-month',
//                    'isActive' => false,
//                    'key'      => 'this_month',
//                ], [
//                    'name'     => 'admin::app.datagrid.filters.custom',
//                    'isActive' => false,
//                    'key'      => 'custom',
//                ]
//            ]
//        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => "Edit",
            'action' => route('category.mass_destroy'),
            'expect'  => json_encode([
                'category_id' => 'integer',
            ]),
            'method' => 'GET',
            'route'  => 'category.index',
            'icon'   => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'title'        => trans('admin::app.datagrid.delete'),
            'action'       => route('category.mass_destroy'),
            'method'       => 'GET',
            'route'        => 'category.index',
            'confirm_text' => trans('ui::app.datagrid.mass-action.delete', ['resource' => 'product']),
            'icon'         => 'icon trash-icon',
        ]);

        $this->addMassAction([
            'type'   => 'delete',
            'label'  => 'Удалить',
            'expect'  => json_encode([
                'selected' => 'array',
            ]),
            'action' => route('category.mass_destroy'),
            'method' => 'POST',
        ]);

//        $this->addMassAction([
//            'type'    => 'update',
//            'label'   => 'Действие два',
//            'action'  => route('category.index'),
//            'method'  => 'GET',
//            'options' => [
//                trans('admin::app.datagrid.active')    => 1,
//                trans('admin::app.datagrid.inactive')  => 0,
//            ],
//        ]);
    }
}
