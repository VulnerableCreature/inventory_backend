<?php

declare(strict_types=1);

namespace App\Module\Asset\DTO;

use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Support\Arr;

final readonly class CreateAssetDto
{
    public function __construct(
        public string            $originalName,
        public string            $name,
        public ?string           $inventoryNumber,
        public float             $price,
        public int               $quantity,
        public DateTimeImmutable $dateRegistration,
    )
    {
    }

    public static function fromRequest(array $data): CreateAssetDto
    {
        return new self(
            Arr::get($data, 'originalName'),
            Arr::get($data, 'name'),
            Arr::get($data, 'inventoryNumber'),
            Arr::get($data, 'price'),
            Arr::get($data, 'quantity'),
            Carbon::parse(Arr::get($data, 'dateRegistration'))->toImmutable(),
        );
    }
}
