<?php

namespace App\Http\Requests\Room;

use App\Models\Room;
use App\Module\Room\DTO\UpdateRoomDto;
use App\Module\Room\Enums\RoomTypeEnum;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

/**
 * @property string $name
 * @property string $building
 */
final class UpdateRoomRequest extends FormRequest
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
    public function rules(#[RouteParameter('id')] int $id): array
    {
        return [
            'name' => 'required|string|max:100',
            'number' => [
                'nullable',
                'integer',
                Rule::unique(Room::class, 'number')->ignore($id),
            ],
            'type' => ['required', new Enum(RoomTypeEnum::class)],
            'building' => 'required|string',
            'floor' => 'required|integer|min:1|max:2',
        ];
    }

    public function toDto(): UpdateRoomDto
    {
        return UpdateRoomDto::fromRequest($this->validated());
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name),
            'building' => trim($this->building),
        ]);
    }
}
