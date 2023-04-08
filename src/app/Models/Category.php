<?php

namespace App\Models;

use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;

class Category extends AbstractModel
{
    use HasFactory, NodeTrait, CompanyRelation;

    public const TYPE_SYSTEM = 'system';
    public const TYPE_PUBLIC = 'public';

    public const AVAILABLE_TYPES = [
        self::TYPE_SYSTEM,
        self::TYPE_PUBLIC,
    ];

    public const SLUG_PRODUCTS = 'products';
    public const SLUG_SERVICES = 'services';

    public const RESERVED_SLUGS = [
        self::SLUG_PRODUCTS,
        self::SLUG_SERVICES,
    ];
}
