<?php

namespace App\Models;

use App\Models\Pivot\CompanyPerson;
use App\Traits\HasAddresses;
use App\Traits\HasEmails;
use App\Traits\HasPhones;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 **/
class Company extends AbstractModel
{
    use HasFactory, HasPhones, HasEmails, HasAddresses;

    /**
     * @return BelongsToMany
     */
    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)
            ->using(CompanyPerson::class);
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
