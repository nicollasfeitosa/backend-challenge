<?php

namespace App\Services\Transaction;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Repositories\User\UserRepository;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function create(Transaction $transaction): bool
    {
        return $transaction->save();
    }

    public function delete(Transaction $transaction): bool
    {
        return $transaction->delete();
    }

    public function transactions(User $user): HasMany
    {
        return $this->userRepository->queryWithTransactions($user);
    }

    public function withFilters(User $user, string $period): array
    {
        try {
            $period = Carbon::createFromFormat('m/Y', $period);
            return $user->transactions()->whereMonth('created_at', $period->month)->whereYear('created_at', $period->year)->get()->toArray();
        } catch (InvalidFormatException $exception) {
            if ($period === 'all') {
                return $user->transactions()->get()->toArray();
            }

            if ($period === 'last_month') {
                return $user->transactions()->where('created_at', '>=', Carbon::now()->subDays(30))->get()->toArray();
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
}
