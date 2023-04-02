<?php

namespace App\Traits;

use App\Models\Email;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasEmails
{
    /**
     * @return MorphToMany
     */
    public function emails(): MorphToMany
    {
        return $this->morphToMany(Email::class, 'related', 'morph_email');
    }
}
