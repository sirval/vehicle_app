<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request): JsonResponse
    {
        return $this->authService->userRegister($request);
    }

    public function login(Request $request): JsonResponse
    {
        return $this->authService->userLogin($request);
    }

    public function verifyCode(Request $request): JsonResponse
    {
        return $this->authService->verifyCode($request);
    }

    public function resendCode($id): JsonResponse
    {
        return $this->authService->resendSms($id);
    }

    public function logout(): JsonResponse
    {
        return $this->authService->logout();
    }

    public function refreshToken(): JsonResponse
    {
        return $this->authService->refresh();
    }

    public function me(): JsonResponse
    {
        return $this->authService->me();
    }
}
