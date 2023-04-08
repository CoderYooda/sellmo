<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = [
            'email' => $request->getEmail(),
            'password' => $request->getPassword()
        ];

        if (Auth::attempt($credentials)) {

            try {
                $request->session()->regenerate();
            } catch (\Throwable) {
                Log::debug('Requester has no session');
            }

            return response()->json([
                'status' => 'OK',
                'user' => new UserResource(Auth::user())
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Данные не верны'
        ], 503);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = new User();

        $user->name = $request->getName();
        $user->email = $request->getEmail();
        $user->password = bcrypt($request->getPassword());

        $user->save();

        $user->person()->create([
            'first_name' => 'Без имени',
            'last_name' => 'Без фамилии',
        ]);

        Auth::login($user);

        return response()->json([
            'status' => 'OK',
            'user' => new UserResource(Auth::user())
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        try {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (\Throwable) {
            Log::debug('Requester has no session');
        }

        return response()->json([
            'status' => 'OK',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function whoami(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}
