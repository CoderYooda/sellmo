<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 **/
class Address extends AbstractModel
{
    use HasFactory;

    protected $table = 'addresses';
    protected $guarded = [];

    protected const WORK_ADDRESS = 'work';
    protected const HOME_ADDRESS = 'home';

    public const AVAILABLE_ADDRESS_TYPES = [
        self::WORK_ADDRESS,
        self::HOME_ADDRESS,
    ];
}
