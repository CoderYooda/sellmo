<?php

namespace App\Services\Company;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasCompanyInterface
{
    public function company(): BelongsTo;
    public function getCompany(): ?Company;
}
