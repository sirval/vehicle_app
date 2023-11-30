<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\VerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    protected $verifyService;
    public function __construct(AuthService $authService, VerificationService $verifyService)
    {
        $this->authService = $authService;
        $this->verifyService = $verifyService;
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
        return $this->verifyService->verifyCode($request);
    }

    public function resendCode($id): JsonResponse
    {
        return $this->verifyService->resendSms($id);
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

    public function forgotPassword(Request $request): JsonResponse
    {
        return $this->authService->forgotPassword($request);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        return $this->authService->resetPassword($request);
    }
}
