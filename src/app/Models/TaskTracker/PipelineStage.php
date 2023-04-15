<?php

namespace App\Models\TaskTracker;

use App\Models\AbstractModel;
use App\Models\Company;
use App\Services\Company\HasCompanyInterface;
use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $order
 * @property Company $company {@see PipelineStage::company()}
 * @property Pipeline $pipeline {@see PipelineStage::pipeline()}
 **/
class PipelineStage extends AbstractModel implements HasCompanyInterface
{
    use HasFactory, CompanyRelation;

    protected $table = 'pipeline_stages';
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(Pipeline::class);
    }
}
