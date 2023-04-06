<?php

namespace App\Models;

use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Организация
 *
 * @property int $id
 * @property string $name
 **/
class Organization extends AbstractModel
{
    use HasFactory, CompanyRelation;
}
