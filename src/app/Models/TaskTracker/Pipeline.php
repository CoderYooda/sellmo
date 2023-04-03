<?php

namespace App\Models\TaskTracker;

use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 **/
class Pipeline extends AbstractModel
{
    use HasFactory;

    protected $table = 'pipelines';
    protected $guarded = [];
}
