<?php

namespace App\Services\Core\CompanyProtection;

use App\Models\User;
use App\Services\Company\HasCompanyInterface;

interface CompanyProtectionContract
{
    public function checkAccess(User $user, HasCompanyInterface $model): void;
}
