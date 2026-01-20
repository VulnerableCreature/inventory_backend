<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Room\RoomCollection;
use App\Http\Resources\Wallet\WalletResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserResource extends JsonResource
{
    public $resource = User::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'login' => $this->resource->login,
            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'wallet' => new WalletResource($this->whenLoaded('wallet')),
            'rooms' => new RoomCollection($this->whenLoaded('rooms')),
        ];
    }
}
