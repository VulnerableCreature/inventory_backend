<?php

namespace App\Http\Requests\Asset;

use App\Module\Asset\DTO\CreateAssetDto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string  $originalName
 * @property string  $name
 * @property ?string $inventoryNumber
 * @property float   $price
 */
final class CreateAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'originalName' => 'required|string',
            'name' => 'required|string',
            'inventoryNumber' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'dateRegistration' => 'required|date',
        ];
    }

    public function toDto(): CreateAssetDto
    {
        return CreateAssetDto::fromRequest($this->validated());
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'originalName' => trim($this->originalName),
            'name' => trim($this->name),
            'inventoryNumber' => $this->inventoryNumber === null ? null : trim($this->inventoryNumber),
        ]);
    }
}
