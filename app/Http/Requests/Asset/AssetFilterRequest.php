<?php

namespace App\Http\Requests\Asset;

use Illuminate\Foundation\Http\FormRequest;

final class AssetFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'nullable|string|max:50',
            'quantity' => 'nullable|integer',
            'inventory_number' => 'nullable|string',
        ];
    }

    public function filters(): array
    {
        return $this->only([
            'status',
            'quantity',
            'inventory_number',
        ]);
    }
}
