<?php

namespace App\Models;

use App\Traits\CompanyRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Должность
 *
 * @property int $id
 * @property string $name
 * @property int $company_id
 **/
class Appointment extends AbstractModel
{
    use HasFactory, CompanyRelation;

    public const DIRECTOR = 'director';
    public const MANAGER = 'manager';
    public const EMPLOYEE = 'employee';
    public const CLIENT = 'client';

    public const BASE_APPOINTMENTS = [
        self::DIRECTOR,
        self::MANAGER,
        self::EMPLOYEE,
        self::CLIENT,
    ];
}
