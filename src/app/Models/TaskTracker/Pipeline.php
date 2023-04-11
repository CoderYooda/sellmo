<?php

namespace App\Models\TaskTracker;

use App\Models\AbstractModel;
use App\Models\Company;
use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property Company $company {@see Person::company()}
 **/
class Pipeline extends AbstractModel
{
    use HasFactory, CompanyRelation;

    protected $table = 'pipelines';
    protected $guarded = [];
}
