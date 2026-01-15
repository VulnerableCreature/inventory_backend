<?php

namespace App\Http\Requests\Asset;

use App\Models\Asset;
use App\Module\Asset\DTO\UpdateAssetDto;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string  $originalName
 * @property string  $name
 * @property ?string $inventoryNumber
 * @property float   $price
 */
final class UpdateAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(#[RouteParameter('id')] int $id): array
    {
        return [
            'originalName' => 'required|string',
            'name' => 'required|string',
            'inventoryNumber' => [
                'nullable',
                'string',
                Rule::unique(Asset::class, 'inventory_number')->ignore($id),
            ],
            'dateRegistration' => 'required|date',
            'price' => 'required|numeric',
            'quantity' => 'nullable|integer|min:1',
        ];
    }

    public function toDto(): UpdateAssetDto
    {
        return UpdateAssetDto::fromRequest($this->validated());
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
