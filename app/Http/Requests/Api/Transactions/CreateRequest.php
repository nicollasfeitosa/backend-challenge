<?php

namespace App\Http\Requests\Api\Transactions;

use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:credit,debit,refund',
        ];
    }

    public function toDto(): Transaction
    {
        return new Transaction([
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'type' => $this->type,
        ]);
    }
}
