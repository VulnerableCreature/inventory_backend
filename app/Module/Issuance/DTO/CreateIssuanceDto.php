<?php

declare(strict_types=1);

namespace App\Module\Issuance\DTO;

use App\Shared\Attributes\DTO;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Support\Arr;

#[DTO]
final class CreateIssuanceDto
{
    public function __construct(
        public int               $assetId,
        public int               $roomId,
        public ?int              $deviceId,
        public int               $issuableId,
        public string            $issuableType,
        public int               $quantity,
        public DateTimeImmutable $issuedAt,
    )
    {
    }

    public static function fromRequest(array $data): CreateIssuanceDto
    {
        return new self(
            Arr::get($data, 'assetId'),
            Arr::get($data, 'roomId'),
            Arr::get($data, 'deviceId'),
            Arr::get($data, 'issuableId'),
            Arr::get($data, 'issuableType'),
            Arr::get($data, 'quantity'),
            Carbon::parse(Arr::get($data, 'issuedAt'))->toImmutable(),
        );
    }
}
