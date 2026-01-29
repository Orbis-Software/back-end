<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $service
    ) {}

    public function login(LoginRequest $request)
    {
        $deviceName = substr((string) $request->header('User-Agent', 'spa-token'), 0, 255);

        $result = $this->service->login(
            email: $request->email,
            password: $request->password,
            deviceName: $deviceName
        );

        $result['user']->load('company');

        return response()->json([
            'user'  => new UserResource($result['user']),
            'token' => $result['token'],
        ]);
    }

    public function me()
    {
        $user = $this->service->me();
        return new UserResource($user);
    }

    /**
     * Logout only the current token (recommended for multi-device).
     */
    public function logout(): \Illuminate\Http\Response
    {
        $this->service->logoutCurrentToken();
        return response()->noContent();
    }

    /**
     * OPTIONAL: Logout all devices (delete all tokens).
     * Add route if you want this endpoint.
     */
    public function logoutAll(): \Illuminate\Http\Response
    {
        $this->service->logoutAllTokens();
        return response()->noContent();
    }
}
