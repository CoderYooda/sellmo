<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Operations\Company\CompanyOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psr\Log\LoggerInterface;

class AuthController extends Controller
{
    protected CompanyOperation $companyOperation;
    protected LoggerInterface $logger;

    public function __construct(
        CompanyOperation $companyOperation,
        LoggerInterface $logger,
    ) {
        $this->companyOperation = $companyOperation;
        $this->logger = $logger;
    }

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
                $this->logger->debug('Requester has no session');
            }

            return response()->json([
                'status' => 'ok',
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
        $user = $this->companyOperation->create(
            $request->getCompanyName(),
            $request->getFirstName(),
            $request->getLastName(),
            $request->getMiddleName(),
            $request->getName(),
            $request->getEmail(),
            $request->getPassword(),
        );

        Auth::login($user);

        return response()->json([
            'status' => 'ok',
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
            $this->logger->debug('Requester has no session');
        }

        return response()->json([
            'status' => 'ok',
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
