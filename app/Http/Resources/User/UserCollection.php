<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Override;

final class UserCollection extends ResourceCollection
{
    public $collects = UserResource::class;

    #[Override]
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
