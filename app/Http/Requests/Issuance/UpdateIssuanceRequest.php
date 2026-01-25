<?php

namespace App\Http\Requests\Issuance;

use App\Module\Issuance\DTO\UpdateIssuanceDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateIssuanceRequest extends FormRequest
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
            'assetId' => 'required|integer|exists:assets,id',
            'roomId' => 'required|integer|exists:rooms,id',
            'deviceId' => 'nullable|integer|exists:assets,id',
            'issuableId' => 'required|integer',
            'issuableType' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'issuedAt' => 'required|date',
        ];
    }

    public function toDto(): UpdateIssuanceDto
    {
        return UpdateIssuanceDto::fromRequest($this->validated());
    }
}
