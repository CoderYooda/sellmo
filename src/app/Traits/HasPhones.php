<?php

namespace App\Traits;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasPhones
{
    /**
     * @return MorphToMany
     */
    public function phones(): MorphToMany
    {
        return $this->morphToMany(Phone::class, 'related', 'morph_phone');
    }
}
