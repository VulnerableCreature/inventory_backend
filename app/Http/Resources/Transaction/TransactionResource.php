<?php

namespace App\Http\Resources\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TransactionResource extends JsonResource
{
    public $resource = Transaction::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'type' => [
                'value' => $this->resource->type->value,
                'label' => $this->resource->type->label(),
            ],
            'amount' => $this->resource->amount->toArray(),
            'balance_before' => $this->resource->balance_before->toArray(),
            'balance_after' => $this->resource->balance_after->toArray(),
            'status' => [
                'value' => $this->resource->status->value,
                'label' => $this->resource->status->label(),
            ],
            'created_at' => $this->resource->created_at,
        ];
    }
}
