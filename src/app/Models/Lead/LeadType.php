<?php

namespace App\Models\Lead;

use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 **/
class LeadType extends Model
{
    use HasFactory, CompanyRelation;

    protected $table = 'lead_types';
    protected $guarded = [];
}
