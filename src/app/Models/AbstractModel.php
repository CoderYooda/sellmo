<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\LazyCollection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AbstractModel
 * @method static static create(array $attributes)
 * @method static static firstOrCreate(array $attributes)
 * @method static static make(array $values)
 * @method static static|null find($id, $columns = array())
 * @method static static findOrFail($id, $columns = array())
 * @method static static first()
 * @method static LazyCollection|static[] cursor()
 * @method static Builder select($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder whereRaw($sql, $bindings = [], $boolean = 'and')
 * @method static Builder whereNull($column)
 * @method static Builder whereNotNull($column)
 * @method static Builder whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder whereNotIn(string $column, array $values, string $boolean = 'and')
 * @method static Builder join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
 * @method static Builder orderBy($column, $direction = 'asc')
 * @method static Builder orderByDesc($fields)
 * @method static Builder latest($column = 'created_at')
 */
abstract class AbstractModel extends Model
{

}
