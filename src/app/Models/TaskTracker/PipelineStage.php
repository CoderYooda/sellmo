<?php

namespace App\Models\TaskTracker;

use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 **/
class PipelineStage extends AbstractModel
{
    use HasFactory;

    protected $table = 'pipeline_stages';
    protected $guarded = [];

}
