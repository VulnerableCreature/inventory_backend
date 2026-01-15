<?php

namespace App\Http\Resources\Wallet;

use App\Http\Resources\Transaction\TransactionCollection;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class WalletResource extends JsonResource
{
    public $resource = Wallet::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'balance' => $this->resource->balance->getAmountInDecimal(),
            'currency' => $this->resource->balance->getCurrency(),
            'status' => $this->resource->status,
            'transactions' => new TransactionCollection($this->whenLoaded('transactions')),
        ];
    }
}
