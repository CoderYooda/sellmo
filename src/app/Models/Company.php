<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 **/
class Company extends AbstractModel
{
    use HasFactory;

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)
            ->using(CompanyPerson::class);
    }
}
