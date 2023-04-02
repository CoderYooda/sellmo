<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 **/
class Email extends AbstractModel
{
    use HasFactory;

    protected $table = 'emails';
    protected $guarded = [];

    protected const WORK_EMAIL = 'work';
    protected const HOME_EMAIL = 'home';

    public const AVAILABLE_EMAIL_TYPES = [
        self::HOME_EMAIL,
        self::WORK_EMAIL,
    ];

    /**
     * @return MorphToMany
     */
    public function companies(): MorphToMany
    {
        return $this->morphedByMany(Company::class, 'related', 'morph_email');
    }

    /**
     * @return MorphToMany
     */
    public function persons(): MorphToMany
    {
        return $this->morphedByMany(Person::class, 'related', 'morph_email');
    }
}
