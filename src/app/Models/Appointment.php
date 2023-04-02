<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 **/
class Appointment extends AbstractModel
{
    use HasFactory;

    public const DIRECTOR = 'director';
    public const MANAGER = 'manager';
    public const EMPLOYEE = 'employee';

    public const BASE_APPOINTMENTS = [
        self::DIRECTOR,
        self::MANAGER,
        self::EMPLOYEE,
    ];
}
