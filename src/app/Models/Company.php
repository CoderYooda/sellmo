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

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)
            ->using(CompanyPerson::class);
    }
}
