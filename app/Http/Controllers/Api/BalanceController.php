<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Balance\BalanceService;

class BalanceController extends Controller
{
    public function __construct(private BalanceService $balanceService)
    {
    }

    public function show(User $user): JsonResponse
    {
        $balance = $this->balanceService->balance($user);

        return response()->json([
            'balance' => round($balance, 2),
        ]);
    }
}
