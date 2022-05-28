<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Transaction;
use App\Utils\ExporterHelper;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Services\Transaction\TransactionService;
use App\Http\Requests\Api\Transactions\CreateRequest;
use App\Http\Requests\Api\Transactions\ExportRequest;

class TransactionController extends Controller
{
    private const DEFAULT_PAGINATION = 5;

    public function __construct(private TransactionService $transactionService)
    {
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $transaction = $request->toDto();

        $isTransactionSaved = $this->transactionService->create($transaction);

        if (!$isTransactionSaved) {
            return response()->json('Error when creating transaction', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($transaction, Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        $transactions = $this->transactionService->transactions($user)->paginate(self::DEFAULT_PAGINATION);

        return (new Collection(["user" => $user, "transactions" => $transactions]));
    }

    public function destroy(Transaction $transaction): JsonResponse
    {
        $isDeleted = $this->transactionService->delete($transaction);

        if (!$isDeleted) {
            return response()->json('Error when deleting transaction', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    public function export(User $user, ExportRequest $request)
    {
        try {
            $transactions = $this->transactionService->withFilters($user, $request->get('period'));
            $path = storage_path("app/public/transactions.csv");

            if (count($transactions) === 0) {
                return response()->json(['message' => 'No transactions found in this period'], 404);
            }

            $headers = ['transactionId', 'userId', 'amount', 'type', 'created_at'];
            ExporterHelper::exportCsv($transactions, $headers, $path);

            return response()->download($path)->deleteFileAfterSend(true);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Error when exporting transactions'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
