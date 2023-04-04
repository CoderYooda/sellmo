<?php

namespace App\Models\TaskTracker;

use App\Models\AbstractModel;
use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 **/
class PipelineStage extends AbstractModel
{
    use HasFactory, CompanyRelation;

    protected $table = 'pipeline_stages';
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function leadSource(): BelongsTo
    {
        return $this->belongsTo(Pipeline::class);
    }
}
