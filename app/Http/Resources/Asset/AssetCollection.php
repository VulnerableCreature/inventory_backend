<?php

namespace App\Http\Resources\Asset;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Override;

final class AssetCollection extends ResourceCollection
{
    public $collects = AssetResource::class;

    #[Override]
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
