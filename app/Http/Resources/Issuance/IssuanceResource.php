<?php

namespace App\Http\Resources\Issuance;

use App\Http\Resources\Asset\AssetResource;
use App\Http\Resources\Room\RoomResource;
use App\Http\Resources\User\UserResource;
use App\Models\Issuance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class IssuanceResource extends JsonResource
{
    public $resource = Issuance::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'creator' => $this->when(
                $this->resource->relationLoaded('creator'),
                fn() => new UserResource($this->resource->creator)
            ),
            'asset' => $this->when(
                $this->resource->relationLoaded('asset'),
                fn() => new AssetResource($this->resource->asset)
            ),
            'room' => $this->when(
                $this->resource->relationLoaded('room'),
                fn() => new RoomResource($this->resource->room)
            ),
            'device' => $this->when(
                $this->resource->relationLoaded('device'),
                fn() => new AssetResource($this->resource->device)
            ),
            'issuable' => $this->when(
                $this->resource->relationLoaded('issuable'),
                fn() => [
                    'id' => $this->resource->issuable->id,
                    'type' => $this->resource->issuable_type,
                    'name' => $this->resource->issuable->shortName,
                ]
            ),
            'quantity' => $this->resource->quantity,
            'status' => $this->resource->status->value,
            'issuedAt' => $this->resource->issued_at,
            'returnedAt' => $this->resource->returned_at,
            'createdAt' => $this->resource->created_at,
        ];
    }
}
