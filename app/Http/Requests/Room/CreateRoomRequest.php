<?php

namespace App\Http\Requests\Room;

use App\Module\Room\DTO\CreateRoomDto;
use App\Module\Room\Enums\RoomTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property string $name
 * @property string $building
 */
final class CreateRoomRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'number' => 'required|integer',
            'type' => ['required', new Enum(RoomTypeEnum::class)],
            'building' => 'required|string|max:255',
            'floor' => 'required|integer|min:1|max:2',
        ];
    }

    public function toDto(): CreateRoomDto
    {
        return CreateRoomDto::fromRequest($this->validated());
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name),
            'building' => trim($this->building),
        ]);
    }
}
