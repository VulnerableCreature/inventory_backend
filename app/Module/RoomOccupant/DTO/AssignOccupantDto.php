<?php

declare(strict_types=1);

namespace App\Module\RoomOccupant\DTO;

use App\Module\RoomOccupant\Entity\OccupantEntity;
use App\Module\RoomOccupant\Exceptions\InvalidOccupantDataException;

final class AssignOccupantDto
{
    /**
     * @throws InvalidOccupantDataException
     */
    public function __construct(public array $occupants)
    {
        $this->validate();
    }

    /**
     * @throws InvalidOccupantDataException
     */
    private function validate(): void
    {
        if (empty($this->occupants)) {
            throw new InvalidOccupantDataException('At least one occupant must be provided', 422);
        }
    }

    /**
     * @throws InvalidOccupantDataException
     */
    public static function fromRequest(array $data): AssignOccupantDto
    {
        $occupants = array_map(
            fn(array $item) => OccupantEntity::fromArray($item),
            $data['occupants']
        );

        return new self(
            occupants: $occupants
        );
    }
}
