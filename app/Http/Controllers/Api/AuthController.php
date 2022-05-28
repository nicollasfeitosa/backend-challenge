<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Auth\LoginRequest;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->all();

        if (!Auth::attempt($credentials)) {
            return $this->error('Credentials not match', Response::HTTP_UNAUTHORIZED);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
            'user' => auth()->user()
        ]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->success(['message' => 'Logout success']);
    }
}
