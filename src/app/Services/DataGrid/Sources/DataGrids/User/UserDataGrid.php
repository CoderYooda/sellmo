<?php

namespace Bitex\Admin\DataGrids\User;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
//use Bitex\Admin\Traits\ProvideDropdownOptions;
use Bitex\Lead\Repositories\PipelineRepository;
use Bitex\Lead\Repositories\StageRepository;
use Bitex\UI\DataGrid\DataGrid;
use Bitex\User\Repositories\UserRepository;

class UserDataGrid extends DataGrid
{
//    use ProvideDropdownOptions;


    protected $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;

        parent::__construct();
    }

    public function init()
    {
        $this->setRowProperties([
            'backgroundColor' => '#ffd0d6',
            'condition' => function ($row) {
                return false;
            }
        ]);
    }

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('users')
            ->addSelect(
                'users.id',
                'users.name',
                'users.email',
                'users.created_at',
            );

        $this->addFilter('id', 'users.id');
        $this->addFilter('name', 'users.name');
        $this->addFilter('email', 'users.email');
        $this->addFilter('created_at', 'users.created_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'    => 'id',
            'label'    => "ID",
            'type'     => 'string',
            'sortable' => true,
        ]);

        $this->addColumn([
            'index'            => 'name',
            'label'            => "Имя",
            'type'             => 'dropdown',
            'dropdown_options' => [],
            'searchable'       => false,
            'sortable'         => true,
            'closure'          => function ($row) {
                return "<a href='#'>туц</a>";
            },
        ]);

        $this->addColumn([
            'index'    => 'email',
            'label'    => "Почта",
            'type'     => 'string',
            'sortable' => true,
        ]);
        $this->addColumn([
            'index'      => 'created_at',
            'label'      => "Дата создания",
            'type'       => 'date_range',
            'searchable' => false,
            'sortable'   => true,
            'closure'    => function ($row) {
                return $row->created_at;
            },
        ]);
    }

    public function prepareTabFilters()
    {
        $this->addTabFilter([
            'key'        => 'type',
            'type'       => 'pill',
            'condition'  => 'eq',
            'value_type' => 'lookup',
            'values'     => [1, 2],
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => "Просмотр",
            'method' => 'GET',
            'route'  => 'user.list',
            'icon'   => 'eye-icon',
        ]);

        $this->addAction([
            'title'        => "Удалить",
            'method'       => 'GET',
            'route'        => 'user.list',
            'confirm_text' => "awd",
            'icon'         => 'trash-icon',
        ]);
    }

    public function prepareMassActions()
    {
//        $stages = [];
//
//        foreach ($this->pipeline->stages->toArray() as $stage) {
//            $stages[$stage['name']] = $stage['id'];
//        }
//
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => "Удалить",
            'action' => route('user.list'),
            'method' => 'get',
        ]);
//
//        $this->addMassAction([
//            'type'    => 'update',
//            'label'   => trans('admin::app.datagrid.update_stage'),
//            'action'  => route('admin.leads.mass_update'),
//            'method'  => 'PUT',
//            'options' => $stages,
//        ]);
    }
}
