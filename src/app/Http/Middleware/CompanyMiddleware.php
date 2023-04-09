<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CompanyMiddleware
{
    /**
     * Автоматическое поределение Компании
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if(!$user){
            throw new AuthenticationException('no auth');
        }

        $companyId = Cache::remember('user_' . $user->id . '_company', 900, function() use ($user) {

            return $user->getCompany()?->id ?? false;
        });

        if(!$companyId){
            throw new AuthenticationException('no company');
        }

        $request->merge(['company_id' => $companyId]);

        return $next($request);
    }
}
