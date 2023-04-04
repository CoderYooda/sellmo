<?php

namespace App\Models\TaskTracker;

use App\Models\AbstractModel;
use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 **/
class Pipeline extends AbstractModel
{
    use HasFactory, CompanyRelation;

    protected $table = 'pipelines';
    protected $guarded = [];
}
