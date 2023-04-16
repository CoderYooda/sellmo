<?php

namespace App\Models;

use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $sku
 * @property string $name
 * @property string $type
 * @property int $company_id
 * @property int $category_id
 * @property Company $company {@see Product::company()}
 * @property Category $category {@see Product::category()}
 **/
class Product extends AbstractModel
{
    use HasFactory, CompanyRelation;

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
