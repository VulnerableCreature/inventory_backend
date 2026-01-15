<?php

namespace App\Http\Requests\Authorization;

use App\Module\Authorization\DTO\AuthorizationUserDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class AuthorizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function toDto(): AuthorizationUserDto
    {
        return AuthorizationUserDto::fromRequest($this->validated());
    }
}
