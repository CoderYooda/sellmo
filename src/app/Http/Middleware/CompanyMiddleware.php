<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CompanyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        $companyId = Cache::remember('user_' . $user->id . '_company', 900, function() use ($user) {

            return $user->getCompany()->id ?? false;
        });

        $request->merge(['company_id' => $companyId]);

        return $next($request);
    }
}
