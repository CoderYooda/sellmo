<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class AbstractModel
 * @method static Builder select($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder whereRaw($sql, $bindings = [], $boolean = 'and')

 */
class Role extends \Spatie\Permission\Models\Role
{
    public const ROLE_ADMIN = 'admin';
    public const CRM_USER = 'crm_user';

    public const SYSTEM_ROLES = [
        self::ROLE_ADMIN,
        self::CRM_USER,
    ];
}
