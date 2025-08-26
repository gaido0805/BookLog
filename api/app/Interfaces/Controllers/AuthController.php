<?php

namespace App\Interfaces\Controllers;

use App\Domain\UseCases\Auth\LoginUserUseCase;
use App\Domain\UseCases\Auth\RegisterUserUseCase;
use App\Interfaces\Requests\LoginRequest;
use App\Interfaces\Requests\RegisterRequest;
use App\Interfaces\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private RegisterUserUseCase $registerUserUseCase;
    private LoginUserUseCase $loginUserUseCase;

    public function __construct(
        RegisterUserUseCase $registerUserUseCase,
        LoginUserUseCase $loginUserUseCase
    ) {
        $this->registerUserUseCase = $registerUserUseCase;
        $this->loginUserUseCase = $loginUserUseCase;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->registerUserUseCase->execute($request->validated());
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->loginUserUseCase->execute(
            $request->email,
            $request->password
        );

        if (!$user) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => new UserResource($request->user()),
        ]);
    }
}
