<?php

namespace App\Http\Resources\User;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProfileResource extends JsonResource
{
    public $resource = Profile::class;

    public function toArray(Request $request): array
    {
        return [
            'surname' => $this->resource->surname,
            'name' => $this->resource->name,
            'middleName' => $this->resource->middleName,
        ];
    }
}
