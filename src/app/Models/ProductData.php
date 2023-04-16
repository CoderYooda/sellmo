<?php

namespace App\Models;

use App\Traits\CompanyRelation;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $slug
 * @property double $price
 * @property double $special_price
 * @property CarbonInterface $special_price_from
 * @property CarbonInterface $special_price_to
 * @property Product $product {@see ProductData::product()}
 **/
class ProductData extends AbstractModel
{
    use HasFactory, CompanyRelation;

    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
