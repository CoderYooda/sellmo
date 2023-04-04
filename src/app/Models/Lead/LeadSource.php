<?php

namespace App\Models\Lead;

use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadSource extends Model
{
    use HasFactory, CompanyRelation;

    protected $table = 'lead_sources';
    protected $guarded = [];
}
