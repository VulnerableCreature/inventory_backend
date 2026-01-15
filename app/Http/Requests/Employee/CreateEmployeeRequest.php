<?php

namespace App\Http\Requests\Employee;

use App\Module\Employee\DTO\CreateEmployeeDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $surname
 * @property string $name
 * @property string $middleName
 */
final class CreateEmployeeRequest extends FormRequest
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

    public function toDto(): CreateEmployeeDto
    {
        return CreateEmployeeDto::fromRequest($this->validated());
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'surname' => trim($this->surname),
            'name' => trim($this->name),
            'middleName' => trim($this->middleName),
        ]);
    }
}
