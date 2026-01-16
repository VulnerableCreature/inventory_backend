<?php

namespace App\Http\Resources\Room;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class RoomResource extends JsonResource
{
    public $resource = Room::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'number' => $this->resource->number,
            'type' => [
                'value' => $this->resource->type->value,
                'label' => $this->resource->type->label(),
            ],
            'building' => $this->resource->building,
            'floor' => $this->resource->floor,
        ];
    }
}
