<?php

declare(strict_types=1);

namespace App\Module\RoomOccupant\Entity;

final readonly class OccupantEntity
{
    public function __construct(
        public int    $id,
        public string $type,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            type: $data['type']
        );
    }
}
