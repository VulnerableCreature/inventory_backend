<?php

namespace App\Http\Requests\User;

use App\Module\User\DTO\CreateUserDto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $login
 * @property string $password
 */
final class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ];
    }

    public function toDto(): CreateUserDto
    {
        return CreateUserDto::fromRequest($this->validated());
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'login' => trim($this->login),
            'password' => trim($this->password),
        ]);
    }
}
