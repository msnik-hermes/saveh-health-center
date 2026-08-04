<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        /** @var User|null $user */
        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['ایمیل یا رمز عبور نادرست است.'],
            ]);
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['حساب کاربری غیرفعال است.'],
            ]);
        }

        $deviceName = $credentials['device_name'] ?? ($request->userAgent() ?: 'mobile-app');
        $token = $user->createToken($deviceName)->plainTextToken;

        $user->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ])->save();

        return response()->json([
            'success' => true,
            'message' => 'ورود موفق',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user->loadMissing(['center', 'employee'])),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => new UserResource($user->loadMissing(['center', 'employee'])),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $token = $user->currentAccessToken();

        if ($token) {
            // PersonalAccessToken model or transient token both support delete via tokenable relation
            method_exists($token, 'delete')
                ? $token->delete()
                : $user->tokens()->where('id', $token->id ?? 0)->delete();
        }

        // Ensure no residual tokens with same name in test/mobile flows
        if ($request->filled('revoke_all') && $request->boolean('revoke_all')) {
            $user->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'خروج انجام شد',
        ]);
    }
}
