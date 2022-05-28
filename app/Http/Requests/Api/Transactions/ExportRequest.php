<?php

namespace App\Http\Requests\Api\Transactions;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
{
    private const ALLOWED_TYPES = ['all', 'last_month'];

    public function rules()
    {
        $rules = ['period' => 'date_format:m/Y'];

        if (!$this->has('period')) {
            return [
                'period' => 'required'
            ];
        }

        $period = $this->get('period');

        if (in_array($period, self::ALLOWED_TYPES)) {
            $rules['period'] = 'required|in:all,last_month';
        }

        return $rules;
    }
}
