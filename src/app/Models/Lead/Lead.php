<?php

namespace App\Models\Lead;

use App\Models\Company;
use App\Models\Organization;
use App\Models\Person;
use App\Models\TaskTracker\Pipeline;
use App\Models\TaskTracker\PipelineStage;
use App\Traits\CompanyRelation;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string title
 * @property string description
 * @property int lead_value
 * @property string status
 * @property string lost_reason
 * @property CarbonInterface closed_at
 * @property LeadSource leadSource
 * @property Person creator
 * @property Person person
 * @property LeadType leadType
 * @property Pipeline pipeline
 * @property PipelineStage pipelineStage
 * @property Company company
 * @property CarbonInterface created_at
 * @property CarbonInterface updated_at
 **/
class Lead extends Model
{
    use HasFactory, CompanyRelation;

    protected $table = 'leads';
    protected $guarded = [];

    public const STATUS_INIT = 'init';
    public const STATUSES = [
        self::STATUS_INIT,
    ];

    /**
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * @return BelongsTo
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * @return BelongsTo
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
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
    public function pipelineStage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class);
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
