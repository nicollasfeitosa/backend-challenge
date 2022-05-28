<?php

namespace Unit\Services\Balance;

use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use App\Services\Balance\BalanceService;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class BalanceServiceTest extends TestCase
{
    private const USER_INITIAL_BALANCE = 100;

    public function testCalculateBalance()
    {
        $this->setupMock();

        $service = new BalanceService($this->userRepositoryMock);

        $this->transactions->add(
            new Transaction(
                [
                    'id' => 1,
                    'user_id' => 1,
                    'amount' => 100,
                    'type' => 'credit'
                ]
            )
        );

        $this->transactions->add(
            new Transaction(
                [
                    'id' => 2,
                    'user_id' => 1,
                    'amount' => 50,
                    'type' => 'refund'
                ]
            )
        );

        $this->transactions->add(
            new Transaction(
                [
                    'id' => 3,
                    'user_id' => 1,
                    'amount' => 50,
                    'type' => 'debit'
                ]
            )
        );

        $this->user->transactions = $this->transactions;
        $this->userRepositoryMock->method('collectionWithTransactions')->with($this->user)->willReturn($this->user->transactions);

        $got = $service->balance($this->user);
        $expected = 200;

        $this->assertEquals($expected, $got);
    }

    public function setupMock()
    {
        $this->userRepositoryMock = $this->createMock(UserRepository::class);

        $this->user = new User(
            [
                'id' => 1,
                'name' => 'Unit Test User',
                'email' => 'example@test.com',
            ]
        );

        $this->user->initialBalance = self::USER_INITIAL_BALANCE;

        $this->transactions = new Collection();
    }
}
