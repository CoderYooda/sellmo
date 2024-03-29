<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property int $phone
 **/
class Phone extends AbstractModel
{
    use HasFactory;

    protected $table = 'phones';
    protected $guarded = [];

    protected const WORK_PHONE = 'work';
    protected const HOME_PHONE = 'home';

    public const AVAILABLE_PHONE_TYPES = [
        self::HOME_PHONE,
        self::WORK_PHONE,
    ];

    /**
     * @return Attribute
     */
    public function phone(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value,
            set: fn ($value) => (int) phoneToFormat($value),
        );
    }

    /**
     * @return MorphToMany
     */
    public function companies(): MorphToMany
    {
        return $this->morphedByMany(Company::class, 'related', 'morph_phone');
    }

    /**
     * @return MorphToMany
     */
    public function persons(): MorphToMany
    {
        return $this->morphedByMany(Person::class, 'related', 'morph_phone');
    }
}
