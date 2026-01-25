<?php

namespace App\Http\Resources\Issuance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Override;

final class IssuanceCollection extends ResourceCollection
{
    public $collects = IssuanceResource::class;

    #[Override]
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
