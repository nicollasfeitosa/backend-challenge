<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface UserRepositoryInterface
{
    public function collectionWithTransactions(User $user): Collection;
    public function queryWithTransactions(User $user): HasMany;
}
