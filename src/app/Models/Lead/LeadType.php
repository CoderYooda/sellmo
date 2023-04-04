<?php

namespace App\Models\Lead;

use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadType extends Model
{
    use HasFactory, CompanyRelation;

    protected $table = 'lead_types';
    protected $guarded = [];
}
