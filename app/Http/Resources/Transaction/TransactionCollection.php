<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Override;

final class TransactionCollection extends ResourceCollection
{
    public $collects = TransactionResource::class;

    #[Override]
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
