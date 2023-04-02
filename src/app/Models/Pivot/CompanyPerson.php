<?php

namespace App\Models\Pivot;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyPerson extends Pivot
{
    use HasFactory;

    protected $table = 'company_person';

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
