<?php

namespace App\Traits;

use App\Models\Address;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasAddresses
{
    /**
     * @return MorphToMany
     */
    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'related', 'morph_address');
    }
}
