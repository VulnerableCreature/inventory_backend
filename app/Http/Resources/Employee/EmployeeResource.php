<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\Room\RoomCollection;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class EmployeeResource extends JsonResource
{
    public $resource = Employee::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'surname' => $this->resource->surname,
            'name' => $this->resource->name,
            'middleName' => $this->resource->middleName,
            'rooms' => new RoomCollection($this->whenLoaded('rooms')),
        ];
    }
}
