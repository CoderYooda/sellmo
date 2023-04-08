<?php

namespace App\Traits;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait CompanyRelation
{
    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return ?Company
     */
    public function getCompany(): ?Company
    {
        /** @var Company $company */
        $company = $this->company()->first();

        return $company;
    }
}
