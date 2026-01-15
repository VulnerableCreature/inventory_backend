<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

final class UserFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'nullable|integer|exists:users,id',
            'login' => 'nullable|string|exists:users,login',
            'surname' => 'nullable|string',
        ];
    }

    public function filters(): array
    {
        return $this->only([
            'id',
            'login',
            'surname',
        ]);
    }
}
