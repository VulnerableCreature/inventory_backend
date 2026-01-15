<?php

namespace App\Http\Resources\Asset;

use App\Http\Resources\User\UserResource;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AssetResource extends JsonResource
{
    public $resource = Asset::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'original_name' => $this->resource->original_name,
            'name' => $this->resource->name,
            'inventory_number' => $this->resource->inventory_number,
            'status' => [
                'value' => $this->resource->status->value,
                'label' => $this->resource->status->label()
            ],
            'date_registration' => $this->resource->date_registration,
            'price' => $this->resource->price->toArray(),
            'quantity' => $this->resource->quantity,
            'termination_date' => $this->resource->termination_date,
            'created_at' => $this->resource->created_at,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
