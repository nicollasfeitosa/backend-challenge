<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;

class UserService
{
    public function __construct(UserRepository $userRepository)
    {
    }

    public function create(User $user): bool
    {
        return $user->save();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function updateInitialBalance(User $user, float $initialBalance): bool
    {
        $user->initialBalance = $initialBalance;

        return $user->save();
    }
}
