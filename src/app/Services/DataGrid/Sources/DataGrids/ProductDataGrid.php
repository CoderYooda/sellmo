<?php

namespace App\Services\DataGrid\Sources\DataGrids;

use App\Models\Product;
use App\Repositories\Ecommerce\ProductRepository;
use App\Services\DataGrid\DataGrid;

class ProductDataGrid extends DataGrid
{
    protected ProductRepository $productRepository;

    protected string $sortOrder = 'desc';

    protected string $index = 'id';

    protected $itemsPerPage = 10;

    protected string $locale = 'all';

    protected string $channel = 'all';

    protected array $extraFilters = [
        'channels',
        'locales',
    ];

    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
        parent::__construct();
    }

    /**
     * @return void
     */
    public function prepareQueryBuilder(): void
    {
        $queryBuilder = $this->productRepository->gridQueryBuilder();

        $this->addFilter('product_id', 'products.id');
        $this->addFilter('product_name', 'products.name');
        $this->addFilter('sku', 'products.sku');

        $this->setQueryBuilder($queryBuilder);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function addColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => 'ID',
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
            'closure'    => function ($row) {
                if ($row->id < 2) {
                    return "<a href='/' target='_blank'>" . $row->id . "</a>";
                }

                return $row->name;
            },
        ]);

        $this->addColumn([
            'index'      => 'sku',
            'label'      => "Артикул",
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'price',
            'label'      => "Стоимость",
            'type'       => 'int',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($product) {
                /** @var Product $product */
                if (isset($product->special_price)) {
                    return $product->price . " (" . $product->special_price . ")";
                }

                return $product->price;
            },
        ]);

    }

    /**
     * @return void
     */
    public function prepareActions(): void
    {
        $this->addAction([
            'title'     => 'Действие',
            'method'    => 'GET',
            'action'    => 'GET',
            'route'     => 'admin.lead.create',
            'icon'      => 'icon pencil-lg-icon',
            'condition' => function () {
                return true;
            },
        ]);

        $this->addAction([
            'title'        => 'Действие2',
            'method'       => 'POST',
            'action'       => 'www.google.com',
            'route'        => 'admin.lead.create',
            'confirm_text' => "Текст подтверждения",
            'icon'         => 'icon trash-icon',
        ]);
    }

    /**
     * @return void
     */
    public function prepareMassActions(): void
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => "Массовое действие",
            'action' => "admin.lead.create",
            'method' => 'GET',
        ]);

        $this->addMassAction([
            'type'    => 'update',
            'label'   => "Массовое действие 2",
            'action'  => "admin.lead.create",
            'method'  => 'GET',
            'options' => [
                "option1"    => 1,
                "option2"  => 0,
            ],
        ]);
    }
}
