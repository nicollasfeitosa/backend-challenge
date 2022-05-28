<?php

namespace App\Services\Balance;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

class BalanceService
{
    private const DEBIT_TYPE = 'debit';

    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function balance(User $user): float
    {
        $transactions = $this->userRepository->collectionWithTransactions($user);

        $balance = $user->initialBalance ?? 0;

        foreach ($transactions as $transaction) {
            if ($transaction->type === self::DEBIT_TYPE) {
                $balance -= $transaction->amount;
                continue;
            }

            $balance += $transaction->amount;
        }

        return $balance;
    }
}
