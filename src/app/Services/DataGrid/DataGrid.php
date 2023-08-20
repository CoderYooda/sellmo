<?php

namespace App\Services\DataGrid;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use App\Services\DataGrid\Traits\ProvideBouncer;
use App\Services\DataGrid\Traits\ProvideCollection;
use App\Services\DataGrid\Traits\ProvideExceptionHandler;
use App\Services\DataGrid\Traits\ProvideExport;

abstract class DataGrid
{
    use ProvideBouncer, ProvideCollection, ProvideExceptionHandler, ProvideExport;

    protected string $index = 'id';
    protected string $sortOrder = 'asc';
    protected Builder $queryBuilder;
    protected bool $enableFilterMap = false;
    protected array $filterMap = [];
    protected array $rowProperties = [];
    protected array $columns = [];
    protected $completeColumnDetails = [];
    protected bool $enableAction = false;
    protected array $actions = [];
    protected bool $enableMassAction = false;
    protected array $massActions = [];
    protected $collection;
    protected array $parse;
    protected bool $paginate = true;
    protected bool $enablePerPage = true;
    protected $itemsPerPage = 10;
    protected bool $enableSearch = true;
    protected bool $enableFilters = true;
    protected array $operators = [
        'eq'       => '=',
        'lt'       => '<',
        'gt'       => '>',
        'lte'      => '<=',
        'gte'      => '>=',
        'neqs'     => '<>',
        'neqn'     => '!=',
        'eqo'      => '<=>',
        'like'     => 'like',
        'blike'    => 'like binary',
        'nlike'    => 'not like',
        'ilike'    => 'ilike',
        'and'      => '&',
        'bor'      => '|',
        'regex'    => 'regexp',
        'notregex' => 'not regexp',
    ];
    protected array $bindings = [
        0 => 'select',
        1 => 'from',
        2 => 'join',
        3 => 'where',
        4 => 'having',
        5 => 'order',
        6 => 'union',
    ];
    protected array $selectComponents = [
        0  => 'aggregate',
        1  => 'columns',
        2  => 'from',
        3  => 'joins',
        4  => 'wheres',
        5  => 'groups',
        6  => 'havings',
        7  => 'orders',
        8  => 'limit',
        9  => 'offset',
        10 => 'lock',
    ];
    protected bool $export = false;

    public function __construct()
    {
        $this->invoker = $this;
    }

    public function init()
    {
    }

    /**
     * @return void
     */
    abstract public function prepareQueryBuilder(): void;

    /**
     * @return void
     */
    abstract public function addColumns(): void;

    /**
     * @return void
     */
    public function prepareActions()
    {
    }

    /**
     * @return void
     */
    public function prepareMassActions()
    {
    }

    /**
     * @param ?string $name
     * @return void
     */
    public function fireEvent(string $name = null): void
    {
        if (isset($name)) {
            $className = get_class($this->invoker);

            $className = last(explode('\\', $className));

            $className = strtolower($className);

            $eventName = $className . '.' . $name;

            Event::dispatch($eventName, $this->invoker);
        }
    }

    /**
     * @param array $rowProperties
     * @return void
     * @throws \Exception
     */
    public function setRowProperties(array $rowProperties): void
    {
        $this->checkRequiredRowPropertiesKeys($rowProperties);

        $this->rowProperties = $rowProperties;
    }

    /**
     * @param Builder $queryBuilder
     * @return void
     */
    public function setQueryBuilder(Builder $queryBuilder): void
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param array $column
     * @return void
     */
    public function setCompleteColumnDetails(array $column): void
    {
        $this->completeColumnDetails[] = $column;
    }

    /**
     * @param string $alias
     * @param string $column
     * @return void
     */
    public function addFilter(string $alias, string $column): void
    {
        $this->filterMap[$alias] = $column;

        $this->enableFilterMap = true;
    }

    /**
     * @param array $column
     * @return void
     * @throws \Exception
     */
    public function addColumn(array $column): void
    {
        $this->checkRequiredColumnKeys($column);

        $this->fireEvent('add.column.before.' . $column['index']);

        $this->columns[] = $column;

        $this->setCompleteColumnDetails($column);

        $this->fireEvent('add.column.after.' . $column['index']);
    }

    /**
     * @param array $action
     * @param bool $specialPermission
     * @return void
     * @throws \Exception
     */
    public function addAction(array $action, bool $specialPermission = false): void
    {
        $this->checkRequiredActionKeys($action);

        $this->checkPermissions($action, $specialPermission, function ($action, $eventName) {
            $this->fireEvent('action.before.' . $eventName);

            $action['key'] = Str::slug($action['title'], '_');

            $this->actions[] = $action;

            $this->enableAction = true;

            $this->fireEvent('action.after.' . $eventName);
        });
    }

    /**
     * @param array $massAction
     * @param bool $specialPermission
     * @return void
     */
    public function addMassAction(array $massAction, bool $specialPermission = false): void
    {
        $massAction['route'] = $this->getRouteNameFromUrl($massAction['action'], $massAction['method']);

        $this->checkPermissions($massAction, $specialPermission, function ($action, $eventName) {
            $this->fireEvent('mass.action.before.' . $eventName);

            $this->massActions[] = $action;
            $this->enableMassAction = true;

            $this->fireEvent('mass.action.after.' . $eventName);
        }, 'label');
    }

    /**
     * @return array
     */
    public function prepareData(): array
    {
        return [
            'index'             => $this->index,
            'export'            => $this->export,
            'className'         => Crypt::encryptString(get_called_class()),
            'records'           => $this->collection,
            'columns'           => $this->completeColumnDetails,
            'tabFilters'        => $this->tabFilters,
            'customTabFilters'  => $this->customTabFilters,
            'enableActions'     => $this->enableAction,
            'actions'           => $this->actions,
            'enableMassActions' => $this->enableMassAction,
            'massActions'       => $this->massActions,
            'paginated'         => $this->paginate,
            'itemsPerPage'      => $this->itemsPerPage,
            'enableSearch'      => $this->enableSearch,
            'enablePerPage'     => $this->enablePerPage,
            'enableFilters'     => $this->enableFilters,
        ];
    }

    /**
     * @return object
     */
    public function toJson(): object
    {
        $this->init();

        $this->addColumns();

        $this->prepareTabFilters();

        $this->prepareActions();

        $this->prepareMassActions();

        $this->prepareQueryBuilder();

        $this->getCollection();

        $this->formatCollection();

        return response()->json($this->prepareData());
    }
}
