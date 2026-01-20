<?php

namespace App\Http\Resources\Room;

use App\Shared\Entity\Occupant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class OccupantResource extends JsonResource
{
    public $resource = Occupant::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'type' => $this->resource->type,
            'shortName' => $this->resource->shortName,
        ];
    }
}
