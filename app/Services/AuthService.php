<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $users
    ) {}

    public function login(string $email, string $password, ?string $deviceName = null): array
    {
        $user = $this->users->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            // Generic error: do not reveal whether email exists
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $tokenName = $deviceName ?: 'spa-token';

        // Optional abilities (future):
        // $abilities = ['orbis:access'];

        return [
            'user'  => $user,
            'token' => $user->createToken($tokenName /*, $abilities*/)->plainTextToken,
        ];
    }

    /**
     * Logout only the current access token (current device).
     */
    public function logoutCurrentToken(): void
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return;
        }

        /** @var PersonalAccessToken|null $token */
        $token = $user->currentAccessToken();

        if ($token) {
            $token->delete();
        }
    }

    /**
     * Logout all devices (delete all tokens).
     */
    public function logoutAllTokens(): void
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return;
        }

        $user->tokens()->delete();
    }
}
