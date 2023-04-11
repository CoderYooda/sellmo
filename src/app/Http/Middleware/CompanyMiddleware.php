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
     * Автоматическое определение Компании
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

        if(!$user->person->company){
            throw new AuthenticationException('no company');
        }

        $request->merge(['user' => $user]);

        return $next($request);
    }
}
