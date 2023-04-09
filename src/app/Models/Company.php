<?php

namespace App\Models;

use App\Traits\HasAddresses;
use App\Traits\HasEmails;
use App\Traits\HasPhones;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 **/
class Company extends AbstractModel
{
    use HasFactory, HasPhones, HasEmails, HasAddresses;

    /**
     * @return BelongsTo
     */
    public function persons(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
