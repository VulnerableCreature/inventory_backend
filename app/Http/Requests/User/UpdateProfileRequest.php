<?php

namespace App\Http\Requests\User;

use App\Module\User\DTO\UpdateProfileDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateProfileRequest extends FormRequest
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
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'middleName' => 'required|string|max:255',
        ];
    }

    public function toDto(): UpdateProfileDto
    {
        return UpdateProfileDto::fromRequest($this->validated());
    }
}
