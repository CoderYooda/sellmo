<?php

namespace App\Services\Core\CompanyProtection;

use App\Models\User;
use App\Services\Company\HasCompanyInterface;
use Illuminate\Auth\Access\AuthorizationException;

trait CheckCompanyAccess
{
    /**
     * @throws AuthorizationException
     */
    public function checkAccess(
        User $user,
        HasCompanyInterface $model
    ): void {
        $cannotUse = $user->cannot('useCompanyModel', [
            'model' => $model
        ]);
        if($cannotUse){
            throw new AuthorizationException();
        }
    }
}
