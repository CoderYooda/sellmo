<?php

namespace App\Models\Lead;

use App\Models\TaskTracker\Pipeline;
use App\Models\TaskTracker\PipelineStage;
use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory, CompanyRelation;

    protected $table = 'leads';
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function pipelineStage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class);
    }

    /**
     * @return BelongsTo
     */
    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(Pipeline::class);
    }

    /**
     * @return BelongsTo
     */
    public function leadType(): BelongsTo
    {
        return $this->belongsTo(LeadType::class);
    }

    /**
     * @return BelongsTo
     */
    public function leadSource(): BelongsTo
    {
        return $this->belongsTo(LeadSource::class);
    }
}
