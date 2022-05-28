<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRepository implements UserRepositoryInterface
{
    public function collectionWithTransactions(User $user): Collection
    {
        return $user->transactions()->get();
    }

    public function queryWithTransactions(User $user): HasMany
    {
        return $user->transactions();
    }
}
