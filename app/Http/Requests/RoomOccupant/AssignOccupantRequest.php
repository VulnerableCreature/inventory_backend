<?php

namespace App\Http\Requests\RoomOccupant;

use App\Module\RoomOccupant\DTO\AssignOccupantDto;
use App\Module\RoomOccupant\Exceptions\InvalidOccupantDataException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class AssignOccupantRequest extends FormRequest
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
            'occupants' => ['required', 'array', 'min:1'],
            'occupants.*.id' => ['required', 'integer'],
            'occupants.*.type' => ['required', 'string', 'in:user,employee'],
        ];
    }

    /**
     * @throws InvalidOccupantDataException
     */
    public function toDto(): AssignOccupantDto
    {
        return AssignOccupantDto::fromRequest($this->validated());
    }
}
