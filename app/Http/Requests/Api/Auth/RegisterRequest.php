<?php

namespace App\Http\Requests\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'birthday' => 'required|date:Y-m-d',
            'initalBalance' => 'numeric'
        ];
    }

    public function toDto(): User
    {
        return new User([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'birthday' => $this->birthday,
            'initialBalance' => $this->initalBalance,
        ]);
    }
}
