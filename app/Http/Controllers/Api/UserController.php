<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UpdateRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(['users' => User::all()->sortByDesc('created_at')]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $request->toDto();

        if ($user->isUnderage()) {
            return response()->json(['message' => 'User is underage'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $isUserCreated = $this->userService->create($user);

        if (!$isUserCreated) {
            return response()->json(['message' => 'Error creating user'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($user, JsonResponse::HTTP_CREATED);
    }

    public function update(User $user, UpdateRequest $request): JsonResponse
    {
        $isUpdated = $this->userService->updateInitialBalance($user, $request->initialBalance);

        if (!$isUpdated) {
            return response()->json(['message' => 'User could not be updated'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(['user' => $user]);
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->hasTransactions() || $user->initialBalance > 0) {
            return response()->json(['message' => 'Cannot delete user because has transactions or money in account'], Response::HTTP_UNAUTHORIZED);
        }

        $isUserDeleted = $this->userService->delete($user);

        if (!$isUserDeleted) {
            return response()->json(['message' => 'User could not be deleted'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
