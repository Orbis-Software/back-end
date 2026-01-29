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
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        // ✅ Ensure company is present in response
        $user->load('company');

        $tokenName = $deviceName ?: 'spa-token';

        return [
            'user'  => $user,
            'token' => $user->createToken($tokenName)->plainTextToken,
        ];
    }

    /**
     * ✅ Authenticated user profile (me) with company loaded.
     * Keeps controller thin + ensures refresh won't drop company.
     */
    public function me(): User
    {
        /** @var User|null $user */
        $user = Auth::guard('sanctum')->user();

        if (! $user) {
            abort(401, 'Unauthenticated');
        }

        $user->load('company');

        return $user;
    }

    /**
     * Logout only the current access token (current device).
     */
    public function logoutCurrentToken(): void
    {
        /** @var User|null $user */
        $user = Auth::guard('sanctum')->user();

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
        $user = Auth::guard('sanctum')->user();

        if (! $user) {
            return;
        }

        $user->tokens()->delete();
    }
}
