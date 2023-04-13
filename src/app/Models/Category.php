<?php

namespace App\Models;

use App\Services\Company\HasCompanyInterface;
use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $slug
 * @property int $company_id
 * @property int $parent_id
 * @property Company $company {@see Category::company()}
 **/
class Category extends AbstractModel implements HasCompanyInterface
{
    use HasFactory, NodeTrait, CompanyRelation;

    protected $guarded = [];

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

    /**
     * @return bool
     */
    public function isSystem(): bool
    {
        return $this->type === self::TYPE_SYSTEM;
    }
}
